<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\Association;
use Cake\Utility\Inflector;

/**
 * BillRecords Controller
 *
 * @property \App\Model\Table\BillRecordsTable $BillRecords
 */
class BillRecordsController extends AppController
{
    public function view(DataSyncService $dataSyncService, int $billId)
    {
        if (!$this->BillRecords->existsForBillId($billId)) {
            $dataSyncService->syncBill($billId, new EntityChecker());
        }

        $pickedColumns = $this->getRequest()->getQuery('pick');
        if (!empty($pickedColumns)) {
            $this->BillRecords->pick($pickedColumns);
        }

        $data = $this->BillRecords->find('byBillId', billId: $billId)->first();
        $this->viewBuilder()->setOption('serialize', 'data');
        $this->set(compact('data'));
    }

    public function getAssociation(string $associationName)
    {
        $billRecordId = (int)$this->request->getQuery('billRecordId');
        if (empty($billRecordId)) {
            throw new BadRequestException('Missing required query: billRecordId');
        }

        $association = $this
            ->BillRecords
            ->getAssociation(Inflector::pluralize(Inflector::classify(Inflector::underscore($associationName))));

        $pickedColumns = $this->getRequest()->getQuery('pick');
        if (!empty($pickedColumns)) {
            $association->pick($pickedColumns);
        }

        $data = $association
            ->find()
            ->where(['bill_record_id' => $billRecordId]);

        if (in_array($association->type(), [Association::ONE_TO_ONE, Association::MANY_TO_ONE])) {
            $data = $data->first();
        } else {
            $data = $this->paginate($data);
            $this->set('pagination', [
                'page_count' => $data->pageCount(),
                'current_page' => $data->currentPage(),
                'has_next_page' => $data->hasNextPage(),
                'has_prev_page' => $data->hasPrevPage(),
                'count' => $data->count(),
                'total_count' => $data->totalCount(),
                'per_page' => $data->perPage(),
            ]);
        }

        $this->viewBuilder()->setOption('serialize', ['data', 'pagination']);
        $this->set(compact('data'));
    }
}
