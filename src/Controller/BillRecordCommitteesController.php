<?php
declare(strict_types=1);

namespace App\Controller;

use Crud\Controller\ControllerTrait;

/**
 * BillRecordCommittees Controller
 *
 * @property \App\Model\Table\BillRecordCommitteesTable $BillRecordCommittees
 */
class BillRecordCommitteesController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => ['Crud.Index'],
            'listeners' => ['Crud.Api', 'Crud.ApiPagination'],
        ]);
        $this->loadComponent('Pick');
        $this->loadComponent('BillRecordAssociation');
    }
}
