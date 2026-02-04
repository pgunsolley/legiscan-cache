<?php
declare(strict_types=1);

namespace App\Controller;

use App\Listener\BillRecordAssociationListener;
use Cake\Event\EventInterface;
use Crud\Controller\ControllerTrait;

/**
 * BillRecordSponsors Controller
 *
 * @property \App\Model\Table\BillRecordSponsorsTable $BillRecordSponsors
 */
class BillRecordSponsorsController extends AppController
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

    public function index()
    {
        $this->Crud->on('beforePaginate', static function (EventInterface $event) {
            $event
                ->getSubject()
                ->query
                ->contain([
                    'BillRecordSponsorSocials',
                    'BillRecordSponsorCapitolAddresses',
                    'BillRecordSponsorLinks',
                ]);
        });

        $this->Crud->execute();
    }
}
