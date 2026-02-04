<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Crud\Listener\BaseListener;

class BillRecordAssociationListener extends BaseListener
{
    public function beforePaginate(EventInterface $event): void
    {
        $billRecordId = (int)$this->_controller()->getRequest()->getQuery('billRecordId');
        if (empty($billRecordId)) {
            throw new BadRequestException('Missing required query: billRecordId');
        }

        $event->getSubject()->query->where(['bill_record_id' => $billRecordId]);
    }
}