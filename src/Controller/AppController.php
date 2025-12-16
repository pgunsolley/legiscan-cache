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
                    $sessionListRecords = $dataSyncService->syncSessionList(StateAbbreviation::from($query['state']), new AllOrNothing());
                    $this->set(compact('sessionListRecords'));
                } catch (ValueError) {
                    throw new BadRequestException('Invalid value for state');
                }
                break;

            case 'getMasterList':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $masterListRecords = $dataSyncService->syncMasterList($query['id'], new AllOrNothing());
                $this->set(compact('masterListRecords'));
                break;
            
            case 'getBill':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $billRecord = $dataSyncService->syncBill($query['id'], new EntityChecker());
                $this->set(compact('billRecord'));
                break;

            case 'getBillText':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $billTextRecord = $dataSyncService->syncBillText($query['id'], new EntityChecker());
                $this->set(compact('billTextRecord'));
                break;

            case 'getAmendment':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $amendmentRecord = $dataSyncService->syncAmendment($query['id'], new EntityChecker());
                $this->set(compact('amendmentRecord'));
                break;

            case 'getSupplement':
                if (!array_key_exists('id', $query)) {
                    throw new BadRequestException('Missing required query: id');
                }

                $supplementRecord = $dataSyncService->syncSupplement($query['id'], new EntityChecker());
                $this->set(compact('supplementRecord'));
                break;

            default:
                throw new BadRequestException('Invalid operation');
        }
    }
}
