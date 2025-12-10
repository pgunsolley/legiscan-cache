<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Enum\BillRecordSponsorLinkType;
use App\Service\DataSync\AssociationMerger;
use App\Service\DataSync\EntityCheckerInterface;
use App\Service\DataSync\Exception\InvalidResponseBodyException;
use App\Service\DataSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
use Cake\Collection\CollectionInterface;
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

        $apiResponseBody = $this->legiscanApiService->getBill($billId);
        if (!array_key_exists('bill', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getBill response body missing key 'bill'");
        }

        $entity->set('last_sync', Date::now());
        $associationMerger = new AssociationMerger($entity);
        $bill = $apiResponseBody['bill'];
        if ($bill->get('change_hash') !== $bill['change_hash']) {
            if (array_key_exists('session', $bill)) {
                $associationMerger->mergeOneToOne(
                    associationName: 'BillRecordSessions',
                    data: $bill['session'],
                );
            }

            if (array_key_exists('progress', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordProgresses',
                    data: $bill['progress'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'event' => $item['event'],
                    ]),
                );
            }

            if (array_key_exists('committee', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordCommittees',
                    data: $bill['committee'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'committee_id' => $item['committee_id'],
                        'chamber_id' => $item['chamber_id'],
                        'name' => $item['name'],
                    ]),
                );
            }

            if (array_key_exists('referrals', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordReferrals',
                    data: $bill['referrals'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'committee_id' => $item['date'],
                        'chamber_id' => $item['chamber_id'],
                        'name' => $item['name'],
                    ]),
                );
            }

            if (array_key_exists('history', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordHistories',
                    data: $bill['history'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'chamber_id' => $item['chamber_id'],
                        'action' => $item['action'],
                    ]),
                );
            }

            if (array_key_exists('sponsors', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSponsors',
                    data: $bill['sponsors'],
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'people_id' => $item['people_id'],
                        'party_id' => $item['party_id'],
                        'state_id' => $item['state_id'],
                    ]),
                    descend: static function (AssociationMerger $sponsorMerger, array $item) {
                        if (array_key_exists('bio', $item)) {
                            if (array_key_exists('social', $item['bio'])) {
                                $sponsorMerger->mergeOneToOne(
                                    associationName: 'BillRecordSponsorSocials',
                                    data: $item['bio']['social'],
                                );
                            }

                            if (array_key_exists('capitol_address', $item['bio'])) {
                                $sponsorMerger->mergeOneToOne(
                                    associationName: 'BillRecordSponsorCapitolAddresses',
                                    data: $item['bio']['capitol_address'],
                                );
                            }

                            if (array_key_exists('links', $item['bio'])) {
                                $sponsorMerger->mergeOneToMany(
                                    associationName: 'BillRecordSponsorLinks',
                                    data: $item['bio']['links'],
                                    prepare: static function (array $data) {
                                        $prepared = [];
                                        if (array_key_exists('personal', $data)) {
                                            $prepared[] = [
                                                'bill_record_sponsor_link_type' => BillRecordSponsorLinkType::Personal,
                                                ...$data['personal'],
                                            ];
                                        }

                                        if (array_key_exists('official', $data)) {
                                            $prepared[] = [
                                                'bill_record_sponsor_link_type' => BillRecordSponsorLinkType::Official,
                                                ...$data['official'],
                                            ];
                                        }

                                        return $prepared;
                                    },
                                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                                        'bill_record_sponsor_link_type' => $item['bill_record_sponsor_link_type'],
                                    ]),
                                );
                            }
                        }
                    },
                    transform: static function (array $item) {
                        unset($item['bio']);
                        return $item;
                    },
                );
            }

            if (array_key_exists('sasts', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSasts',
                    data: $bill['sasts'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'type_id' => $item['type_id'],
                        'sast_bill_number' => $item['sast_bill_number'],
                        'sast_bill_id' => $item['sast_bill_id'],
                    ]),
                );
            }

            if (array_key_exists('subjects', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSubjects',
                    data: $bill['subjects'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'subject_id' => $item['subject_id'],
                        'subject_name' => $item['subject_name'],
                    ]),
                );
            }

            if (array_key_exists('texts', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordTexts',
                    data: $bill['texts'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'doc_id' => $item['doc_id'],
                        'date' => $item['date'],
                        'type_id' => $item['type_id'],
                    ]),
                );
            }

            if (array_key_exists('votes', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordVotes',
                    data: $bill['votes'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'roll_call_id' => $item['roll_call_id'],
                        'chamber_id' => $item['chamber_id'],
                        'date' => $item['date'],
                    ]),
                );
            }

            if (array_key_exists('amendments', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordAmendments',
                    data: $bill['amendments'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'amendment_id' => $item['amendment_id'],
                        'chamber_id' => $item['chamber_id'],
                        'date' => $item['date'],
                        'title' => $item['title'],
                    ]),
                );
            }

            if (array_key_exists('supplements', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSupplements',
                    data: $bill['supplements'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'supplement_id' => $item['supplement_id'],
                        'date' => $item['date'],
                        'type_id' => $item['type_id'],
                        'title' => $item['title'],
                    ]),
                );
            }

            if (array_key_exists('calendar', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordCalendars',
                    data: $bill['calendar'], 
                    matcher: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'type_id' => $item['type_id'],
                        'date' => $item['date'],
                        'time' => $item['time'],
                        'description' => $item['description'],
                    ]),
                );
            }            
        }

        return $table->saveOrFail($entity, [
            'associated' => $associatedConfig,
        ]);
    }
}