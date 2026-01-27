<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
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
    }

    public function index(DataSyncService $dataSyncService)
    {
        $sessionId = (int)$this->getRequest()->getQuery('id');
        if (empty($sessionId)) {
            throw new BadRequestException('Missing required query: id');
        }

        if (!$this->MasterListRecords->existsForSessionId($sessionId)) {
            $dataSyncService->syncMasterList($sessionId, new AllOrNothing());
        }

        $this->Crud->on('beforePaginate', static function(EventInterface $event) use ($sessionId) {
            $event->getSubject()->query->find('bySessionId', sessionId: $sessionId);
        });
        $this->Crud->execute();
    }
}
