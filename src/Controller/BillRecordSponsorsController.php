<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSyncService;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;

/**
 * BillRecordSponsors Controller
 *
 * @property \App\Model\Table\BillRecordSponsorsTable $BillRecordSponsors
 */
class BillRecordSponsorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => ['Crud.Index'],
            'listeners' => ['Crud.Api', 'Crud.ApiPagination'],
        ]);
        $this->loadComponent('Pick');
    }

    public function index(DataSyncService $dataSyncService)
    {
        $billRecordId = (int)$this->request->getQuery('billRecordId');
        if (empty($billRecordId)) {
            throw new BadRequestException('Missing required query: billRecordId');
        }

        if (!$this->BillRecordSponsors->BillRecords->existsForPrimaryKey($billRecordId)) {
            $dataSyncService->syncBill($billRecordId, new EntityChecker());
        }

        $this->Crud->on('beforePaginate', static function (EventInterface $event) use ($billRecordId) {
            $event
                ->getSubject()
                ->query
                ->find('byBillRecordId', billRecordId: $billRecordId)
                ->contain([
                    'BillRecordSponsorSocials',
                    'BillRecordSponsorCapitolAddresses',
                    'BillRecordSponsorLinks',
                ]);
        });

        $this->Crud->execute();
    }
}
