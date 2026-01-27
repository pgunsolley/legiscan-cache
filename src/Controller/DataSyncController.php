<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use App\Utility\StateAbbreviation;
use Cake\Http\Exception\BadRequestException;
use Exception;
use ValueError;

class DataSyncController extends AppController
{
    public function getDataSync(DataSyncService $dataSyncService)
    {
        $req = $this->getRequest();
        $query = $req->getQuery();

        if (!array_key_exists('op', $query)) {
            throw new BadRequestException('Missing required query: op');
        }

        switch ($query['op']) {
            case 'getSessionList':
                if (!array_key_exists('state', $query)) {
                    throw new BadRequestException('Missing required query: state');
                }

                try {
                    $data = $dataSyncService->syncSessionList(StateAbbreviation::from($query['state']), new AllOrNothing());
                } catch (ValueError) {
                    throw new BadRequestException('Invalid value for state');
                }

                $this->viewBuilder()->setTemplate('session_list');
                break;

            case 'getMasterList':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncMasterList((int)$query['id'], new AllOrNothing());
                $this->viewBuilder()->setTemplate('master_list');
                break;
            
            case 'getBill':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncBill((int)$query['id'], new EntityChecker());
                $this->viewBuilder()->setTemplate('bill');
                break;

            case 'getBillText':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncBillText((int)$query['id'], new EntityChecker());
                $this->viewBuilder()->setTemplate('bill_text');
                break;

            case 'getAmendment':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncAmendment((int)$query['id'], new EntityChecker());
                $this->viewBuilder()->setTemplate('amendment');
                break;

            case 'getSupplement':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncSupplement((int)$query['id'], new EntityChecker());
                $this->viewBuilder()->setTemplate('supplement');
                break;

            default:
                throw new BadRequestException('Invalid operation');
        }

        if (!isset($data)) {
            throw new Exception('$data var is not set');
        }

        $this->set(compact('data'));
    }
}