<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\AmendmentRecord;
use App\Model\Entity\BillRecord;
use App\Model\Entity\BillTextRecord;
use App\Model\Entity\SupplementRecord;
use App\Model\Enum\BillRecordSponsorLinkType;
use App\Service\DataSync\AssociationMerger;
use App\Service\DataSync\EntityCheckerInterface;
use App\Service\DataSync\Exception\InvalidResponseBodyException;
use App\Service\DataSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Query\SelectQuery;
use TypeError;

class DataSyncService
{
    use LocatorAwareTrait;

    protected LegiscanApiService $legiscanApiService;

    public function __construct(LegiscanApiService $legiscanApiService)
    {
        $this->legiscanApiService = $legiscanApiService;
    }

    protected function sessionIdExists(int $sessionId)
    {
        return $this
            ->fetchTable('SessionListRecords')
            ->find()
            ->where(['session_id' => $sessionId])
            ->count() > 0;
    }

    protected function billIdExists(int $billId)
    {
        return $this
            ->fetchTable('MasterListRecords')
            ->find()
            ->where(['bill_id' => $billId])
            ->count() > 0;
    }

    protected function docIdExists(int $docId)
    {
        return $this
            ->fetchTable('BillRecordTexts')
            ->find()
            ->where(['doc_id' => $docId])
            ->count() > 0;
    }

    protected function amendmentIdExists(int $amendmentId)
    {
        return $this
            ->fetchTable('BillRecordAmendments')
            ->find()
            ->where(['amendment_id' => $amendmentId])
            ->count() > 0;
    }

    protected function supplementIdExists(int $supplementId)
    {
        return $this
            ->fetchTable('BillRecordSupplements')
            ->find()
            ->where(['supplement_id' => $supplementId])
            ->count() > 0;
    }

    public function syncSessionList(StateAbbreviation $state, ResultSetCheckerInterface $checker): iterable
    {
        $table = $this->fetchTable('SessionListRecords');
        $entities = $table
            ->find()
            ->select([
                'id',
                'session_id',
                'last_sync',
                'session_hash',
            ])
            ->where([
                'state_abbr' => $state,
            ])
            ->all();

        if (!$checker->isSetExpired($entities)) {
            return $entities;
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
            ]) ?? $table->newEntity($sessionListItem);

            $entity->set('last_sync', $syncDate);
            if (!$entity->isNew() && $entity->get('session_hash') !== $sessionListItem['session_hash']) {
                $table->patchEntity($entity, $sessionListItem);
            }

            $entitiesToSave[] = $entity;
        }

        return $table->saveManyOrFail($entitiesToSave);
    }

    public function syncMasterList(int $sessionId, ResultSetCheckerInterface $checker): iterable
    {
        if (!$this->sessionIdExists($sessionId)) {
            throw new RecordNotFoundException();
        }

        $table = $this->fetchTable('MasterListRecords');
        $entities = $table
            ->find()
            ->select([
                'id',
                'bill_id',
                'last_sync',
                'change_hash',
            ])
            ->where([
                'session_id' => $sessionId,
            ])
            ->all();
        if (!$checker->isSetExpired($entities)) {
            return $entities;
        }

        $apiResponseBody = $this->legiscanApiService->getMasterList($sessionId);
        if (!array_key_exists('masterlist', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getMasterList response body missing key 'masterlist'");
        }

        $masterList = $apiResponseBody['masterlist'];
        unset($masterList['session']);
        $syncDate = Date::now();
        $entitiesToSave = [];
        foreach ($masterList as $masterListItem) {
            /** @var \App\Model\Entity\MasterListRecord $entity */
            $entity = $entities->firstMatch([
                'bill_id' => $masterListItem['bill_id'],
            ]) ?? $table->newEntity($masterListItem);

            $entity->set('last_sync', $syncDate);
            if ($entity->isNew()) {
                $entity->set('session_id', $sessionId);
            } else if ($entity->get('change_hash') !== $masterListItem['change_hash']) {
                $table->patchEntity($entity, $masterListItem);
            }

            $entitiesToSave[] = $entity;
        }

        return $table->saveManyOrFail($entitiesToSave);
    }

    public function syncBill(int $billId, EntityCheckerInterface $checker): BillRecord
    {
        if (!$this->billIdExists($billId)) {
            throw new RecordNotFoundException();
        }

        $associatedConfig = [
            'BillRecordSessions' => fn(SelectQuery $query) => 
                $query->select([
                    'id',
                    'bill_record_id',
                ])
            ,
            'BillRecordProgresses' => fn(SelectQuery $query) => 
                $query->select([
                    'id',
                    'bill_record_id',
                    'date',
                    'event',
                ])
            ,
            'BillRecordCommittees' => fn(SelectQuery $query) => 
                $query->select([
                    'id',
                    'bill_record_id',
                    'committee_id',
                    'chamber_id',
                    'name',
                ])
            ,
            'BillRecordReferrals' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'date',
                    'committee_id',
                    'chamber_id',
                    'name',
                ])
            ,
            'BillRecordHistories' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'date',
                    'chamber_id',
                    'action',
                ])
            ,
            'BillRecordSponsors' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'people_id',
                    'party_id',
                    'state_id',
                ])
            ,
            'BillRecordSponsors.BillRecordSponsorSocials' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_sponsor_id',
                ])
            ,
            'BillRecordSponsors.BillRecordSponsorCapitolAddresses' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_sponsor_id',
                ])
            ,
            'BillRecordSponsors.BillRecordSponsorLinks' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_sponsor_id',
                    'bill_record_sponsor_link_type',
                ])
            ,
            'BillRecordSasts' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'type_id',
                    'sast_bill_number',
                    'sast_bill_id',
                ])
            ,
            'BillRecordSubjects' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'subject_id',
                    'subject_name',
                ])
            ,
            'BillRecordTexts' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'doc_id',
                    'date',
                    'type_id',
                ])
            ,
            'BillRecordVotes' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'roll_call_id',
                    'chamber_id',
                    'date',
                ])
            ,
            'BillRecordAmendments' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'amendment_id',
                    'chamber_id',
                    'date',
                    'title',
                ])
            ,
            'BillRecordSupplements' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'supplement_id',
                    'date',
                    'type_id',
                    'title',
                ])
            ,
            'BillRecordCalendars' => fn(SelectQuery $query) =>
                $query->select([
                    'id',
                    'bill_record_id',
                    'type_id',
                    'date',
                    'time',
                    'description',
                ])
            ,
        ];

        /** @var \App\Model\Table\BillRecordsTable $table */
        $table = $this->fetchTable('BillRecords');
        /** @var \App\Model\Entity\BillRecord $entity */
        $entity = $table
            ->find()
            ->select([
                'id',
                'bill_id',
                'last_sync',
                'change_hash',
            ])
            ->where([
                'bill_id' => $billId,
            ])
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
        $bill = $apiResponseBody['bill'];
        if ($entity->get('change_hash') !== $bill['change_hash']) {
            $associationMerger = new AssociationMerger($entity);
            if (array_key_exists('session', $bill)) {
                $associationMerger->mergeOneToOne(
                    associationName: 'BillRecordSessions',
                    data: $bill['session'],
                );
                unset($bill['session']);
            }

            if (array_key_exists('progress', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordProgresses',
                    data: $bill['progress'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'event' => $item['event'],
                    ]),
                );
                unset($bill['progress']);
            }

            if (array_key_exists('committee', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordCommittees',
                    data: $bill['committee'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'committee_id' => $item['committee_id'],
                        'chamber_id' => $item['chamber_id'],
                        'name' => $item['name'],
                    ]),
                );
                unset($bill['committee']);
            }

            if (array_key_exists('referrals', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordReferrals',
                    data: $bill['referrals'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'committee_id' => $item['date'],
                        'chamber_id' => $item['chamber_id'],
                        'name' => $item['name'],
                    ]),
                );
                unset($bill['referrals']);
            }

            if (array_key_exists('history', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordHistories',
                    data: $bill['history'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'date' => $item['date'],
                        'chamber_id' => $item['chamber_id'],
                        'action' => $item['action'],
                    ]),
                );
                unset($bill['history']);
            }

            if (array_key_exists('sponsors', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSponsors',
                    data: $bill['sponsors'],
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
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
                                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                                        'bill_record_sponsor_link_type' => $item['bill_record_sponsor_link_type'],
                                    ]),
                                );
                            }
                        }
                    },
                    beforeMerge: static function (array $item) {
                        unset($item['bio']);
                        return $item;
                    },
                );
                unset($bill['sponsors']);
            }

            if (array_key_exists('sasts', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSasts',
                    data: $bill['sasts'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'type_id' => $item['type_id'],
                        'sast_bill_number' => $item['sast_bill_number'],
                        'sast_bill_id' => $item['sast_bill_id'],
                    ]),
                );
                unset($bill['sasts']);
            }

            if (array_key_exists('subjects', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSubjects',
                    data: $bill['subjects'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'subject_id' => $item['subject_id'],
                        'subject_name' => $item['subject_name'],
                    ]),
                );
                unset($bill['subjects']);
            }

            if (array_key_exists('texts', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordTexts',
                    data: $bill['texts'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'doc_id' => $item['doc_id'],
                        'date' => $item['date'],
                        'type_id' => $item['type_id'],
                    ]),
                );
                unset($bill['texts']);
            }

            if (array_key_exists('votes', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordVotes',
                    data: $bill['votes'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'roll_call_id' => $item['roll_call_id'],
                        'chamber_id' => $item['chamber_id'],
                        'date' => $item['date'],
                    ]),
                );
                unset($bill['votes']);
            }

            if (array_key_exists('amendments', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordAmendments',
                    data: $bill['amendments'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'amendment_id' => $item['amendment_id'],
                        'chamber_id' => $item['chamber_id'],
                        'date' => $item['date'],
                        'title' => $item['title'],
                    ]),
                );
                unset($bill['amendments']);
            }

            if (array_key_exists('supplements', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordSupplements',
                    data: $bill['supplements'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'supplement_id' => $item['supplement_id'],
                        'date' => $item['date'],
                        'type_id' => $item['type_id'],
                        'title' => $item['title'],
                    ]),
                );
                unset($bill['supplements']);
            }

            if (array_key_exists('calendar', $bill)) {
                $associationMerger->mergeOneToMany(
                    associationName: 'BillRecordCalendars',
                    data: $bill['calendar'], 
                    match: fn(CollectionInterface $associated, array $item) => $associated->firstMatch([
                        'type_id' => $item['type_id'],
                        'date' => $item['date'],
                        'time' => $item['time'],
                        'description' => $item['description'],
                    ]),
                );
                unset($bill['calendar']);
            }

            $table->patchEntity($entity, $bill);
        }

        return $table->saveOrFail($entity, [
            'associated' => array_keys($associatedConfig),
        ]);
    }

    public function syncBillText(int $docId, EntityCheckerInterface $checker): BillTextRecord
    {
        if (!$this->docIdExists($docId)) {
            throw new RecordNotFoundException();
        }

        /** @var \App\Model\Table\BillTextRecordsTable $table */
        $table = $this->fetchTable('BillTextRecords');
        /** @var \App\Model\Entity\BillTextRecord */
        $entity = $table->find()->where(['doc_id' => $docId])->first() ?? $table->newEmptyEntity();

        try {
            if (!$checker->isEntityExpired($entity)) {
                return $entity;
            }
        } catch (TypeError $e) {
            if (!$entity->isNew()) {
                throw $e;
            }
        }

        $apiResponseBody = $this->legiscanApiService->getBillText($docId);
        if (!array_key_exists('text', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getBillText response body missing key 'text'");
        }

        $text = $apiResponseBody['text'];
        $entity->set('last_sync', Date::now());
        if ($entity->isNew() || $entity->get('text_hash') !== $text['text_hash']) {
            $table->patchEntity($entity, $text);
        }

        return $table->saveOrFail($entity);
    }

    public function syncAmendment(int $amendmentId, EntityCheckerInterface $checker): AmendmentRecord
    {
        if (!$this->amendmentIdExists($amendmentId)) {
            throw new RecordNotFoundException();
        }

        /** @var \App\Model\Table\AmendmentRecordsTable $table */
        $table = $this->fetchTable('AmendmentRecords');
        /** @var \App\Model\Entity\AmendmentRecord */
        $entity = $table->find()->where(['amendment_id' => $amendmentId])->first() ?? $table->newEmptyEntity();

        try {
            if (!$checker->isEntityExpired($entity)) {
                return $entity;
            }
        } catch (TypeError $e) {
            if (!$entity->isNew()) {
                throw $e;
            }
        }

        $apiResponseBody = $this->legiscanApiService->getAmendment($amendmentId);
        if (!array_key_exists('amendment', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getAmendment response body missing key 'amendment'");
        }

        $amendment = $apiResponseBody['amendment'];
        $entity->set('last_sync', Date::now());
        if ($entity->isNew() || $entity->get('amendment_hash') !== $amendment['amendment_hash']) {
            $table->patchEntity($entity, $amendment);
        }

        return $table->saveOrFail($entity);
    }

    public function syncSupplement(int $supplementId, EntityCheckerInterface $checker): SupplementRecord
    {
        if (!$this->supplementIdExists($supplementId)) {
            throw new RecordNotFoundException();
        }

        /** @var \App\Model\Table\SupplementRecordsTable $table */
        $table = $this->fetchTable('SupplementRecords');
        /** @var \App\Model\Entity\SupplementRecord */
        $entity = $table->find()->where(['supplement_id' => $supplementId])->first() ?? $table->newEmptyEntity();

        try {
            if (!$checker->isEntityExpired($entity)) {
                return $entity;
            }
        } catch (TypeError $e) {
            if (!$entity->isNew()) {
                throw $e;
            }
        }

        $apiResponseBody = $this->legiscanApiService->getSupplement($supplementId);
        if (!array_key_exists('supplement', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getSupplement response body missing key 'supplement'");
        }

        $supplement = $apiResponseBody['supplement'];
        $entity->set('last_sync', Date::now());
        if ($entity->isNew() || $entity->get('supplement_hash') !== $supplement['supplement_hash']) {
            $table->patchEntity($entity, $supplement);
        }

        return $table->saveOrFail($entity);
    }
}