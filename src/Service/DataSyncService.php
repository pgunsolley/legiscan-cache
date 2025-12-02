<?php

declare(strict_types=1);

namespace App\Service;

use Cake\ORM\Locator\LocatorAwareTrait;

class DataSyncService
{
    use LocatorAwareTrait;

    protected LegiscanApiService $legiscanApiService;

    public function __construct(LegiscanApiService $legiscanApiService)
    {
        $this->legiscanApiService = $legiscanApiService;
    }

    public function syncSessionList()
    {
        $sessionListRecordsTable = $this->fetchTable('SessionListRecords');

        // TODO: Configure table validation and app rules
    }
}