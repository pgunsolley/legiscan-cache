<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\BillRecordAssociationListener;
use Crud\Controller\ControllerTrait;

/**
 * BillRecordAmendments Controller
 *
 * @property \App\Model\Table\BillRecordAmendmentsTable $BillRecordAmendments
 */
class BillRecordAmendmentsController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => ['Crud.Index'],
            'listeners' => ['Crud.Api', 'Crud.ApiPagination', BillRecordAssociationListener::class],
        ]);
        $this->loadComponent('Pick');
    }
}
