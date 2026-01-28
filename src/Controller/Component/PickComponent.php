<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;

/**
 * Pick component
 */
class PickComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'separator' => ','
    ];

    public function beforeFilter(EventInterface $event): void
    {
        $controller = $this->getController();
        $pick = $controller->getRequest()->getQuery('pick');
        if (empty($pick)) {
            return;
        }

        $pickedColumns = explode($this->getConfig('separator'), $pick);
        $table = $controller->fetchTable();
        if (!$table->hasBehavior('Pick')) {
            throw new InternalErrorException(sprintf('Table %s does not have PickBehavior', $table->getAlias()));
        }

        $table->pick($pickedColumns);
    }
}
