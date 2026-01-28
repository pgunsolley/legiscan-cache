<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\InternalErrorException;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;

/**
 * Pick behavior
 */
class PickBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'pickable' => [],
    ];

    private array $picked = [];

    public function getPickable(): array
    {
        $columns = $this->table()->getSchema()->columns();
        $pickable = $this->getConfig('pickable');

        if (empty($pickable)) {
            return $columns;
        }

        $notInSchema = array_diff($pickable, $columns);
        if (count($notInSchema) > 0) {
            throw new InternalErrorException(sprintf('Pickable columns not defined in schema: %s', join(', ', $notInSchema)));
        }

        return $pickable;
    }

    public function pick(array $picked): void
    {
        $notAllowed = array_diff($picked, $this->getPickable());
        if (count($notAllowed) > 0) {
            throw new BadRequestException(sprintf('The following picked fields are invalid: %s', join(', ', $notAllowed)));
        }

        $this->picked = $picked;
    }

    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, $primary): void
    {
        if (empty($this->picked)) {
            return;
        }

        $query->select($this->picked);
    }
}
