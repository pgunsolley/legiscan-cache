<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Crud\Controller\ControllerTrait;

/**
 * MasterListRecords Controller
 *
 * @property \App\Model\Table\MasterListRecordsTable $MasterListRecords
 */
class MasterListRecordsController extends AppController
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
        $sessionId = (int)$request->getQuery('id');

        if (empty($sessionId)) {
            throw new BadRequestException('Missing required query: id');
        }

        if (!$this->MasterListRecords->existsForSessionId($sessionId)) {
            $dataSyncService->syncMasterList($sessionId, new AllOrNothing());
        }

        $this->Crud->on('beforePaginate', function(EventInterface $event) use ($sessionId) {
            /** @var \Cake\ORM\Query\SelectQuery $query */
            $query = $event->getSubject()->query;
            $query->find('bySessionId', sessionId: $sessionId);
        });
        $this->Crud->execute();
    }
}
