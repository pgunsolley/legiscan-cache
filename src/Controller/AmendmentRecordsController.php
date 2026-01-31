<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;

/**
 * AmendmentRecords Controller
 *
 * @property \App\Model\Table\AmendmentRecordsTable $AmendmentRecords
 */
class AmendmentRecordsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Pick');
    }

    public function view(DataSyncService $dataSyncService, int $amendmentId)
    {
        if (!$this->AmendmentRecords->existsForAmendmentId($amendmentId)) {
            $dataSyncService->syncAmendment($amendmentId, new EntityChecker());
        }

        $data = $this->AmendmentRecords->find('byAmendmentId', amendmentId: $amendmentId);
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }
}
