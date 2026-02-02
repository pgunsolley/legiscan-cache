<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);
    $routes->get('/data-sync', ['controller' => 'DataSync', 'action' => 'getDataSync']);
    $routes->resources('SessionListRecords', ['only' => ['index']]);
    $routes->resources('MasterListRecords', ['only' => ['index']]);
    $routes->resources('BillTextRecords', ['only' => ['view']]);
    $routes->resources('AmendmentRecords', ['only' => ['view']]);
    $routes->resources('SupplementRecords', ['only' => ['view']]);
    $routes->get('/bill-records', ['controller' => 'BillRecords', 'action' => 'view']);
    $routes
        ->get('/{billRecordAssociation}', ['controller' => 'BillRecords', 'action' => 'getAssociation'])
        ->setPatterns([
            'billRecordAssociation' => join('|', [
                'bill-record-amendments',
                'bill-record-calendars',
                'bill-record-committees',
                'bill-record-histories',
                'bill-record-progresses',
                'bill-record-referrals',
                'bill-record-sasts',
                'bill-record-sessions',
                'bill-record-subjects',
                'bill-record-supplements',
                'bill-record-texts',
                'bill-record-votes',
            ]),
        ])
        ->setPass(['billRecordAssociation']);
    $routes->get('/bill-record-sponsors', ['controller' => 'BillRecordSponsors', 'action' => 'view']);
    $routes
        ->get('/{billRecordSponsorAssociation}', ['controller' => 'BillRecordSponsors', 'action' => 'getAssociation'])
        ->setPatterns([
            'billRecordSponsorAssociation' => join('|', [
                'bill-record-sponsor-socials',
                'bill-record-sponsor-capitol-addresses',
                'bill-record-sponsor-links',
            ]),
        ])
        ->setPass(['billRecordSponsorAssociation']);
};
