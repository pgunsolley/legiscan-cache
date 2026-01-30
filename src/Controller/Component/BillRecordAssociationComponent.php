<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\InternalErrorException;

/**
 * BillRecordAssociation component
 */
class BillRecordAssociationComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];
    
    public function beforeFilter(EventInterface $event): void
    {
        $controller = $this->getController();
        $request = $controller->getRequest();
        $action = $request->getParam('action');

        if (!$controller->fetchTable()->hasBehavior('BillRecordAssociation')) {
            throw new InternalErrorException('Model must have BillRecordAssociationBehavior');
        }

        if ($action === 'index') {
            $billRecordId = (int)$request->getQuery('billRecordId');
            if (empty($billRecordId)) {
                throw new BadRequestException('Missing required query: billRecordId');
            }

            $controller->fetchTable()->setBillRecordId($billRecordId);
        }
    }
}
