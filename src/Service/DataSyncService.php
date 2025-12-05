<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DateSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
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

    public function syncSessionList(StateAbbreviation $state, ResultSetCheckerInterface $checker): array
    {
        throw new NotImplementedException();
    }

    public function syncMasterList(int $sessionId, ResultSetCheckerInterface $checker): void
    {
        throw new NotImplementedException();
    }
}