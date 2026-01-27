<?php
declare(strict_types=1);

namespace App\Controller;

use \Crud\Controller\ControllerTrait;

/**
 * SessionListRecords Controller
 *
 * @property \App\Model\Table\SessionListRecordsTable $SessionListRecords
 */
class SessionListRecordsController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
            ],
        ]);
    }
}
