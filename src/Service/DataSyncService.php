<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Enum\BillRecordSponsorLinkType;
use App\Service\DataSync\EntityCheckerInterface;
use App\Service\DataSync\Exception\InvalidMatchException;
use App\Service\DataSync\Exception\InvalidResponseBodyException;
use App\Service\DataSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\EntityInterface;
use Cake\I18n\Date;
use Cake\ORM\Association;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Inflector;
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
        /** @var \App\Model\Table\BillRecordsTable $table */
        $table = $this->fetchTable('BillRecords');
        /** @var \App\Model\Entity\BillRecord $entity */
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

        // TODO: Replace with AssociationMerger
        $mergeAssociated = function (string $associationName, array $data, ?callable $matcher = null) use ($entity, $table) {
            $association = $table->getAssociation($associationName);
            $property = $association->getProperty();
            $associated = $entity->get($property) ?? $association->newEmptyEntity();

            switch ($association->type()) {
                case Association::ONE_TO_ONE:
                    $association->patchEntity($associated, $data);
                    if ($entity->isNew()) {
                        $associated->set($property, $associated);
                    }
                    break;
                case Association::ONE_TO_MANY:

                    break;
            }


            // TODO: Add check for association type
            /*
            $associationTable = $this->fetchTable($associationName);
            $associationEntities = $entity->get(Inflector::underscore($associationName));
            $collection = new Collection($associationEntities);
            foreach ($data as $item) {
                $associationEntity = $matcher($collection, $item);
                if (!($associationEntity instanceof EntityInterface) && $associationEntity !== null) {
                    throw new InvalidMatchException('matcher result must be a single Entity or null');
                }

                if ($associationEntity === null) {
                    $associationEntity = $associationTable->newEmptyEntity();
                }

                $associationTable->patchEntity($associationEntity, $item);
                if ($associationEntity->isNew()) {
                    $associationEntities[] = $associationEntity;
                }
            }
            */
        };

        $bill = $apiResponseBody['bill'];
        // TODO: Perform validation on associations as soon as possible to exit handle/exit as soon as possible,
        // TODO: But only UPDATE/CREATE as a single ORM op at the end.
        if ($bill->get('change_hash') !== $bill['change_hash']) {
            if (array_key_exists('session', $bill)) {
                /** @var \App\Model\Table\BillRecordSessionsTable $billRecordSessionsTable */
                $billRecordSessionsTable = $this->fetchTable('BillRecordSessions');
                /** @var \App\Model\Entity\BillRecordSession $billRecordSessionEntity */
                $billRecordSessionEntity = $entity->get('bill_record_session') ?? $billRecordSessionsTable->newEmptyEntity();
                $billRecordSessionsTable->patchEntity($billRecordSessionEntity, $bill['session']);
                // Note: Perform validation error handling  here, if necessary.
                if ($billRecordSessionEntity->isNew()) {
                    $entity->set('bill_record_session', $billRecordSessionEntity);
                }
            }

            if (array_key_exists('progress', $bill)) {
                
            }

            if (array_key_exists('committee', $bill)) {
                
            }

            if (array_key_exists('referrals', $bill)) {
                /** @var \App\Model\Table\BillRecordReferralsTable $billRecordReferralsTable */
                $billRecordReferralsTable = $this->fetchTable('BillRecordReferrals');
                /** @var \App\Model\Entity\BillRecordReferral[] $billRecordReferralEntities */
                $billRecordReferralEntities = $entity->get('bill_record_referrals');
                $billRecordReferralCollection = new Collection($billRecordReferralEntities);
                foreach ($bill['referrals'] as $referral) {
                    /** @var \App\Model\Entity\BillRecordReferral $billRecordReferralEntity */
                    $billRecordReferralEntity = $billRecordReferralCollection->firstMatch([
                        'date' => $referral['date'],
                        'committee_id' => $referral['committee_id'],
                        'chamber_id' => $referral['chamber_id'],
                        'name' => $referral['name'],
                    ]) ?? $billRecordReferralsTable->newEmptyEntity();
                    $billRecordReferralsTable->patchEntity($billRecordReferralEntity, $referral);
                    // Note: Perform validation error handling here, if necessary.
                    if ($billRecordReferralEntity->isNew()) {
                        $billRecordReferralEntities[] = $billRecordReferralEntity;
                    }
                }
            }

            if (array_key_exists('history', $bill)) {
                /** @var \App\Model\Table\BillRecordHistoriesTable $billRecordHistoriesTable */
                $billRecordHistoriesTable = $this->fetchTable('BillRecordHistories');
                /** @var \App\Model\Entity\BillRecordHistory[] $billRecordHistoryEntities */
                $billRecordHistoryEntities = $entity->get('bill_record_histories');
                $billRecordHistoryCollection = new Collection($billRecordHistoryEntities);
                foreach ($bill['history'] as $history) {
                    /** @var \App\Model\Entity\BillRecordHistory $billRecordHistoryEntity */
                    $billRecordHistoryEntity = $billRecordHistoryCollection->firstMatch([
                        'date' => $history['date'],
                        'chamber_id' => $history['chamber_id'],
                        'action' => $history['action'],
                    ]) ?? $billRecordHistoriesTable->newEmptyEntity();
                    $billRecordHistoriesTable->patchEntity($billRecordHistoryEntity, $history);
                    // Note: Perform validation error handling here, if necessary.
                    if ($billRecordHistoryEntity->isNew()) {
                        $billRecordHistoryEntities[] = $billRecordHistoryEntity;
                    }
                }
            }

            // TODO: Rewrite this block after rewriting the others
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
                
            }

            if (array_key_exists('subjects', $bill)) {
                
            }

            if (array_key_exists('texts', $bill)) {
                
            }

            if (array_key_exists('votes', $bill)) {
                
            }

            if (array_key_exists('amendments', $bill)) {
                
            }

            if (array_key_exists('supplements', $bill)) {
                
            }

            if (array_key_exists('calendar', $bill)) {
                
            }

            
        }

        
    }
}