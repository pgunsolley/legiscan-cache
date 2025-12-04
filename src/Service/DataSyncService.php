<?php

declare(strict_types=1);

namespace App\Service;

use App\Utility\StateAbbreviation;
use App\Service\DateSync\ResultSetExpirationCheckerInterface;
use Cake\Http\Exception\NotImplementedException;
use Cake\ORM\Locator\LocatorAwareTrait;

class DataSyncService
{
    use LocatorAwareTrait;

    protected LegiscanApiService $legiscanApiService;

    public function __construct(LegiscanApiService $legiscanApiService)
    {
        $this->legiscanApiService = $legiscanApiService;
    }

    public function syncSessionList(StateAbbreviation $state, ResultSetExpirationCheckerInterface $expirationChecker): array
    {
        $sessionListRecordsTable = $this->fetchTable('SessionListRecords');
        $results = $sessionListRecordsTable->find()->where(['state_abbr' => $state->value])->all();
        if (!$expirationChecker->isExpired($results)) {
            return [];
        }

        // TODO: Perform sync. Return array of sync'd session ids
        $legiscanApiResponseData = $this->legiscanApiService->getSessionList($state->value);
        
    }

    public function syncMasterList(int $sessionId, ResultSetExpirationCheckerInterface $expirationChecker): void
    {
        throw new NotImplementedException();
    }
}