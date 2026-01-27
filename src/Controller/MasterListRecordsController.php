<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Utility\Inflector;
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
        $request = $this->getRequest();
        $sessionId = (int)$request->getQuery('id');
        $pick = $request->getQuery('pick');

        if (empty($sessionId)) {
            throw new BadRequestException('Missing required query: id');
        }

        if (!$this->MasterListRecords->existsForSessionId($sessionId)) {
            $dataSyncService->syncMasterList($sessionId, new AllOrNothing());
        }

        $this->Crud->on('beforePaginate', function(EventInterface $event) use ($sessionId, $pick) {
            /** @var \Cake\ORM\Query\SelectQuery $query */
            $query = $event->getSubject()->query;
            $query->find('bySessionId', sessionId: $sessionId);
            if (!empty($pick)) {
                $pickedColumns = array_map(fn(string $pickedColumn) => Inflector::underscore($pickedColumn), explode(',', $pick));
                $allowedColumns = $this->MasterListRecords->getSchema()->columns();
                $notAllowed = array_diff($pickedColumns, $allowedColumns);
                if (count($notAllowed) > 0) {
                    throw new BadRequestException(sprintf('The following picked columns are not allowed: %s', join(', ', $notAllowed)));
                }
                $query->select($pickedColumns);
            }
        });
        $this->Crud->execute();
    }
}
