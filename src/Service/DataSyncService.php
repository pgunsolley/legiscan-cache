<?php

declare(strict_types=1);

namespace App\Service;

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
        $table = $this->fetchTable('BillRecords');
        $entity = $table
            ->find('byBillId', billId: $billId)
            ->contain([
                'BillRecordAmendments',
                'BillRecordCalendars',
                'BillRecordCommittees',
                'BillRecordHistories',
                'BillRecordProgresses',
                'BillRecordReferrals',
                'BillRecordSasts',
                'BillRecordSessions',
                'BillRecordSponsors',
                'BillRecordSubjects',
                'BillRecordSupplements',
                'BillRecordTexts',
                'BillRecordVotes',
            ])
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
        if ($bill->get('change_hash') !== $bill['change_hash']) {
            // TODO: Patch data and all associations
        }

        // TODO: Return $table->saveOrFail()..
    }
}