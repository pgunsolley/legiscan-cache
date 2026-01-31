<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;
use Cake\Utility\Inflector;

/**
 * BillRecords Controller
 *
 * @property \App\Model\Table\BillRecordsTable $BillRecords
 */
class BillRecordsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Pick');
    }

    public function view(DataSyncService $dataSyncService, int $billId)
    {
        if (!$this->BillRecords->existsForBillId($billId)) {
            $dataSyncService->syncBill($billId, new EntityChecker());
        }

        $data = $this->BillRecords->find('byBillId', billId: $billId)->first();
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }

    public function indexAssociation(int $billRecordId, string $associationName)
    {
        $data = $this
            ->BillRecords
            ->getAssociation(Inflector::pluralize(Inflector::classify(Inflector::underscore($associationName))))
            ->find()
            ->where(['bill_record_id' => $billRecordId]);
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }
}
