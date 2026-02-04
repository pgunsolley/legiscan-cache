<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\BillRecordAssociationListener;
use Crud\Controller\ControllerTrait;

/**
 * BillRecordVotes Controller
 *
 * @property \App\Model\Table\BillRecordVotesTable $BillRecordVotes
 */
class BillRecordVotesController extends AppController
{
    use ControllerTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => ['Crud.Index'],
            'listeners' => ['Crud.Api', 'Api.ApiPagination', BillRecordAssociationListener::class],
        ]);
        $this->loadComponent('Pick');
    }
}
