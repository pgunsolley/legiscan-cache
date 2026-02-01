<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;

/**
 * SupplementRecords Controller
 *
 * @property \App\Model\Table\SupplementRecordsTable $SupplementRecords
 */
class SupplementRecordsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Pick');
    }

    public function view(DataSyncService $dataSyncService, int $supplementId)
    {
        if (!$this->SupplementRecords->existsForSupplementId($supplementId)) {
            $dataSyncService->syncSupplement($supplementId, new EntityChecker());
        }

        $data = $this->SupplementRecords->find('bySupplementId', supplementId: $supplementId);
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }
}
