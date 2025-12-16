<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use App\Utility\StateAbbreviation;
use Cake\Controller\Controller;
use Cake\Http\Exception\BadRequestException;
use Cake\View\JsonView;
use Exception;
use ValueError;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function getSyncData(DataSyncService $dataSyncService)
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
                break;

            case 'getMasterList':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncMasterList((int)$query['id'], new AllOrNothing());
                break;
            
            case 'getBill':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncBill((int)$query['id'], new EntityChecker());
                break;

            case 'getBillText':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncBillText((int)$query['id'], new EntityChecker());
                break;

            case 'getAmendment':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncAmendment((int)$query['id'], new EntityChecker());
                break;

            case 'getSupplement':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $data = $dataSyncService->syncSupplement((int)$query['id'], new EntityChecker());
                break;

            default:
                throw new BadRequestException('Invalid operation');
        }

        if (!isset($data)) {
            throw new Exception('$data var is not set');
        }

        $this->set(compact('data'));
        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
