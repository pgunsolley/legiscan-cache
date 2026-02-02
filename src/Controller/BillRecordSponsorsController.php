<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;
use Cake\ORM\Association;
use Cake\Utility\Inflector;

/**
 * BillRecordSponsors Controller
 *
 * @property \App\Model\Table\BillRecordSponsorsTable $BillRecordSponsors
 */
class BillRecordSponsorsController extends AppController
{
    public function view()
    {
        $billRecordId = (int)$this->request->getQuery('billRecordId');
        if (empty($billRecordId)) {
            throw new BadRequestException('Missing required query: billRecordId');
        }

        $pickedColumns = $this->getRequest()->getQuery('pick');
        if (!empty($pickedColumns)) {
            $this->BillRecordSponsors->pick($pickedColumns);
        }

        $data = $this->BillRecordSponsors->findByBillRecordId($billRecordId);
        $this->viewBuilder()->setOption('serialize', ['data']);
        $this->set(compact('data'));
    }

    public function getAssociation(string $associationName)
    {
        $billRecordSponsorId = $this->request->getQuery('billRecordSponsorId');
        if (empty($billRecordSponsorId)) {
            throw new BadRequestException('Missing required query: billRecordSponsorId');
        }

        $association = $this
            ->BillRecordSponsors
            ->getAssociation(Inflector::pluralize(Inflector::classify(Inflector::underscore($associationName))));

        $pickedColumns = $this->request->getQuery('pick');
        if (!empty($pickedColumns)) {
            $association->pick($pickedColumns);
        }

        $data = $association
            ->find()
            ->where(['bill_record_sponsor_id' => $billRecordSponsorId]);

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
