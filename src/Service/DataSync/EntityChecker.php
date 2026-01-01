<?php

declare(strict_types=1);

namespace App\Service\DataSync;

use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\I18n\Date;
use DateInterval;

class EntityChecker implements EntityCheckerInterface
{
    use InstanceConfigTrait;
    
    protected array $_defaultConfig = [
        'field' => 'last_sync',
        'interval' => 'P2D',
    ];

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function getField(): string
    {
        return $this->getConfigOrFail('field');
    }

    public function updateField(EntityInterface $entity): Date
    {
        $now = Date::now();
        $entity->set($this->getField(), $now);
        return $now;
    }

    public function isEntityExpired(EntityInterface $entity): bool
    {
        $entityDate = Date::parse($entity->get($this->getField()));
        $interval = $this->getConfigOrFail('interval');
        if (is_string($interval)) {
            $inverval = new DateInterval($interval);
        }

        return Date::now()->greaterThanOrEquals($entityDate->add($inverval));
    }
}