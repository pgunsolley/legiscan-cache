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

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use App\Utility\StateAbbreviation;
use Cake\Controller\Controller;
use Cake\Http\Exception\BadRequestException;
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
    public function getSyncData(DataSyncService $dataSyncService)
    {
        $request = $this->getRequest();
        $op = $request->getQuery('op');
        $allOrNothingStrategy = new AllOrNothing();

        switch ($op) {
            case 'getSessionList':
                try {
                    $stateAbbr = StateAbbreviation::from($request->getQuery('state'));
                } catch (ValueError $e) {
                    throw new BadRequestException('"state" query param is not valid');
                }

                $sessionListRecords = $dataSyncService->syncSessionList($stateAbbr, $allOrNothingStrategy);
                // TODO: Build view
                
                break;
        }
    }
}
