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

use Cake\ORM\TableRegistry;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Utility\Inflector;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);
    $routes->get('/data-sync', ['controller' => 'DataSync', 'action' => 'getDataSync']);
    $routes->resources('SessionListRecords', ['path' => 'session-list', 'only' => ['index']]);
    $routes->resources('MasterListRecords', ['path' => 'master-list', 'only' => ['index']]);
    $routes->resources('BillTextRecords', ['only' => ['view']]);
    $routes->scope('/bills', static function (RouteBuilder $routes) {
        $routes
            ->get('/{billId}', ['controller' => 'BillRecords', 'action' => 'view'])
            ->setPatterns([
                'billId' => '\d+',
            ])
            ->setPass(['billId']);
        $routes
            ->get('/{billRecordId}/{associationName}', ['controller' => 'BillRecords', 'action' => 'indexAssociation'])
            ->setPatterns([
                'billRecordId' => '\d+',
                'associationName' => join('|', array_map(fn($association) => Inflector::dasherize($association), TableRegistry::getTableLocator()->get('BillRecords')->associations()->keys())),
            ])
            ->setPass(['billRecordId', 'associationName']);
    });
};
