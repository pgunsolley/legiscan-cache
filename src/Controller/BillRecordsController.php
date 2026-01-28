<?php
declare(strict_types=1);

namespace App\Controller;

use Crud\Controller\ControllerTrait;

/**
 * BillRecords Controller
 *
 * @property \App\Model\Table\BillRecordsTable $BillRecords
 */
class BillRecordsController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => ['Crud.View'],
            'listeners' => ['Crud.Api'],
        ]);
    }
}
