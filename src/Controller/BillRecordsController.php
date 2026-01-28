<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSyncService;
use Cake\Http\Exception\BadRequestException;

/**
 * BillRecords Controller
 *
 * @property \App\Model\Table\BillRecordsTable $BillRecords
 */
class BillRecordsController extends AppController
{
    public function view(DataSyncService $dataSyncService, int $billId)
    {
        $req = $this->getRequest();
        $pick = $req->getQuery('pick');
        
        
    }
}
