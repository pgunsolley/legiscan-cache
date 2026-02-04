<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\BillRecordAssociationListener;
use Crud\Controller\ControllerTrait;

/**
 * BillRecordSubjects Controller
 *
 * @property \App\Model\Table\BillRecordSubjectsTable $BillRecordSubjects
 */
class BillRecordSubjectsController extends AppController
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
