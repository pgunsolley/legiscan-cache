<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use App\Utility\StateAbbreviation;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use \Crud\Controller\ControllerTrait;
use ValueError;

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
        $this->loadComponent('Pick');
    }

    public function index(DataSyncService $dataSyncService)
    {
        $request = $this->getRequest();
        $state = $request->getQuery('state');
        
        if (empty($state)) {
            throw new BadRequestException('Missing required query: state');
        }

        try {
            $state = StateAbbreviation::from($state);
        } catch (ValueError) {
            throw new BadRequestException('Value for state must be a valid US State abbreviation');
        }

        if ($this->SessionListRecords->countByState($state) === 0) {
            $dataSyncService->syncSessionList($state, new AllOrNothing());
        }

        $this->Crud->on('beforePaginate', function(EventInterface $event) use ($state) {
            /** @var \Cake\ORM\Query\SelectQuery $query */
            $query = $event->getSubject()->query;
            $query->find('byState', stateAbbreviation: $state);
        });
        $this->Crud->execute();
    }
}
