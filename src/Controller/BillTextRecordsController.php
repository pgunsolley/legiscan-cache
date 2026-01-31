<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;

/**
 * BillTextRecords Controller
 *
 * @property \App\Model\Table\BillTextRecordsTable $BillTextRecords
 */
class BillTextRecordsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Pick');
    }

    public function view(DataSyncService $dataSyncService, int $docId)
    {
        if (!$this->BillTextRecords->existsForDocId($docId)) {
            $dataSyncService->syncBillText($docId, new EntityChecker());
        }

        $data = $this->BillTextRecords->find('byDocId', docId: $docId);
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }
}
