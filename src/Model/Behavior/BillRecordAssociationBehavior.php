<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;

/**
 * BillRecordAssociation behavior
 */
class BillRecordAssociationBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [];

    private ?int $billRecordId = null;

    public function setBillRecordId(int $billRecordId)
    {
        $this->billRecordId = $billRecordId;
    }

    public function findByBillRecordId(SelectQuery $query, int $billRecordId): SelectQuery
    {
        return $query->where(['bill_record_id' => $billRecordId]);
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary): void
    {
        $table = $event->getSubject();

        if (!$table->hasAssociation('BillRecords')) {
            throw new InternalErrorException(sprintf('Table %s does not have BillRecords association', $table->getAlias()));
        }

        if ($this->billRecordId !== null) {
            $query->find('byBillRecordId', billRecordId: $this->billRecordId);
        }
    }
}
