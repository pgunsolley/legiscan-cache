<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Enum\BillRecordSponsorLinkType;
use App\Service\DataSync\EntityCheckerInterface;
use App\Service\DataSync\Exception\InvalidResponseBodyException;
use App\Service\DataSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;
use TypeError;

class DataSyncService
{
    use LocatorAwareTrait;

    protected LegiscanApiService $legiscanApiService;

    public function __construct(LegiscanApiService $legiscanApiService)
    {
        $this->legiscanApiService = $legiscanApiService;
    }

    public function syncSessionList(StateAbbreviation $state, ResultSetCheckerInterface $checker): array
    {
        $table = $this->fetchTable('SessionListRecords');
        $entities = $table->find('byStateAbbreviation', stateAbbreviation: $state)->all();
        if (!$checker->isSetExpired($entities)) {
            return [];
        }

        $apiResponseBody = $this->legiscanApiService->getSessionList($state->value);
        if (!array_key_exists('sessions', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getSessionList response body missing key 'sessions'");
        }

        $sessionList = $apiResponseBody['sessions'];
        $syncDate = Date::now();
        $entitiesToSave = [];
        foreach ($sessionList as $sessionListItem) {
            /** @var \App\Model\Entity\SessionListRecord $entity */
            $entity = $entities->firstMatch([
                'session_id' => $sessionListItem['session_id'],
                'state_id' => $sessionListItem['state_id'],
                'state_abbr' => $sessionListItem['state_abbr'],
                'year_start' => $sessionListItem['year_start'],
                'year_end' => $sessionListItem['year_end'],
            ]) ?? $table->newEntity($sessionListItem);

            $entity->set('last_sync', $syncDate);
            if ($entity->isNew()) {
                $entitiesToSave[] = $entity;
                continue;
            }

            if ($entity->get('session_hash') !== $sessionListItem['session_hash']) {
                $table->patchEntity($entity, $sessionListItem);
            }

            $entitiesToSave[] = $entity;
        }

        return $table->saveManyOrFail($entitiesToSave);
    }

    public function syncMasterList(int $sessionId, ResultSetCheckerInterface $checker): array
    {
        $table = $this->fetchTable('MasterListRecords');
        $entities = $table->find('bySessionId', sessionId: $sessionId)->all();
        if (!$checker->isSetExpired($entities)) {
            return [];
        }

        $apiResponseBody = $this->legiscanApiService->getMasterList($sessionId);
        if (!array_key_exists('masterlist', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getMasterList response body missing key 'masterlist'");
        }

        $masterList = $apiResponseBody['masterlist'];
        $syncDate = Date::now();
        $entitiesToSave = [];
        foreach ($masterList as $masterListItem) {
            /** @var \App\Model\Entity\MasterListRecord $entity */
            $entity = $entities->firstMatch([
                'bill_id' => $masterListItem['bill_id'],
                'number' => $masterListItem['number'],
            ]) ?? $table->newEntity($masterListItem);

            $entity->set('last_sync', $syncDate);
            if ($entity->isNew()) {
                $entitiesToSave[] = $entity;
                continue;
            }

            if ($entity->get('change_hash') !== $masterListItem['change_hash']) {
                $table->patchEntity($entity, $masterListItem);
            }

            $entitiesToSave[] = $entity;
        }

        return $table->saveManyOrFail($entitiesToSave);
    }

    public function syncBill(int $billId, EntityCheckerInterface $checker)
    {
        $associatedConfig = [
            'BillRecordAmendments',
            'BillRecordCalendars',
            'BillRecordCommittees',
            'BillRecordHistories',
            'BillRecordProgresses',
            'BillRecordReferrals',
            'BillRecordSasts',
            'BillRecordSessions',
            'BillRecordSponsors.BillRecordSponsorSocials',
            'BillRecordSponsors.BillRecordSponsorCapitolAddresses',
            'BillRecordSponsors.BillRecordSponsorLinks',
            'BillRecordSubjects',
            'BillRecordSupplements',
            'BillRecordTexts',
            'BillRecordVotes',
        ];
        $table = $this->fetchTable('BillRecords');
        $entity = $table
            ->find('byBillId', billId: $billId)
            ->contain($associatedConfig)
            ->first() ?? $table->newEmptyEntity();

        try {
            if (!$checker->isEntityExpired($entity)) {
                return $entity;
            }
        } catch (TypeError $e) {
            if (!$entity->isNew()) {
                throw $e;
            }
        }

        $entity->set('last_sync', Date::now());
        $apiResponseBody = $this->legiscanApiService->getBill($billId);
        if (!array_key_exists('bill', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getBill response body missing key 'bill'");
        }

        $bill = $apiResponseBody['bill'];
        $patchData = [];
        // TODO: Rewrite this.. the current design was based on the decision to delete existing records and saving
        // TODO: the sync'd data as new entities.
        // TODO: Instead, rewrite to reuse/update existing entities, and only add entities for new data.
        if ($bill->get('change_hash') !== $bill['change_hash']) {
            if (array_key_exists('session', $bill)) {
                $patchData['bill_record_session'] = $bill['session'];
                unset($bill['session']);
            }

            if (array_key_exists('progress', $bill)) {
                $patchData['bill_record_progresses'] = $bill['progress'];
                unset($bill['progress']);
            }

            if (array_key_exists('committee', $bill)) {
                $patchData['bill_record_committees'] = $bill['committee'];
                unset($bill['committee']);
            }

            if (array_key_exists('referrals', $bill)) {
                $patchData['bill_record_referrals'] = $bill['referrals'];
                unset($bill['referrals']);
            }

            if (array_key_exists('history', $bill)) {
                $patchData['bill_record_histories'] = $bill['history'];
                unset($bill['history']);
            }

            if (array_key_exists('sponsors', $bill) && is_array($bill['sponsors'])) {
                foreach ($bill['sponsors'] as $sponsor) {
                    $sponsorPatchData = [];
                    if (array_key_exists('bio', $sponsor)) {
                        if (array_key_exists('social', $sponsor['bio'])) {
                            $sponsorPatchData['bill_record_sponsor_social'] = $sponsor['bio']['social'];
                        }

                        if (array_key_exists('capitol_address', $sponsor['bio'])) {
                            $sponsorPatchData['bill_record_sponsor_capitol_address'] = $sponsor['bio']['capitol_address'];
                        }

                        if (array_key_exists('links', $sponsor['bio'])) {
                            if (array_key_exists('official', $sponsor['bio']['links'])) {
                                $sponsorPatchData['bill_record_sponsor_links'][] = [
                                    'bill_record_sponsor_link_type' => BillRecordSponsorLinkType::Official,
                                    ...$sponsor['bio']['links']['official'],
                                ];
                            }

                            if (array_key_exists('personal', $sponsor['bio']['links'])) {
                                $sponsorPatchData['bill_record_sponsor_links'][] = [
                                    'bill_record_sponsor_link_type' => BillRecordSponsorLinkType::Personal,
                                    ...$sponsor['bio']['links']['personal'],
                                ];
                            }
                        }
                        
                        unset($sponsor['bio']);
                    }

                    $patchData['bill_record_sponsors'][] = [...$sponsorPatchData, ...$sponsor];
                }
            }

            if (array_key_exists('sasts', $bill)) {
                $patchData['bill_record_sasts'] = $bill['sasts'];
                unset($bill['sasts']);
            }

            if (array_key_exists('subjects', $bill)) {
                $patchData['bill_record_subjects'] = $bill['subjects'];
                unset($bill['subjects']);
            }

            if (array_key_exists('texts', $bill)) {
                $patchData['bill_record_texts'] = $bill['texts'];
                unset($bill['texts']);
            }

            if (array_key_exists('votes', $bill)) {
                $patchData['bill_record_votes'] = $bill['votes']; 
                unset($bill['votes']);
            }

            if (array_key_exists('amendments', $bill)) {
                $patchData['bill_record_amendments'] = $bill['amendments'];
                unset($bill['amendments']);
            }

            if (array_key_exists('supplements', $bill)) {
                $patchData['bill_record_supplements'] = $bill['supplements'];
                unset($bill['supplements']);
            }

            if (array_key_exists('calendar', $bill)) {
                $patchData['bill_record_calendars'] = $bill['calendar'];
                unset($bill['calendar']);
            }

            $patchData = [...$patchData, ...$bill];
            $table->patchEntity($entity, $patchData, [
                'associated' => $associatedConfig,
            ]);
        }

        return $table->saveManyOrFail($entity, [
            'associated' => $associatedConfig,
        ]);
    }
}