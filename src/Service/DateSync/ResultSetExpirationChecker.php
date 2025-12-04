<?php

declare(strict_types=1);

namespace App\Service\DateSync;

use Cake\Core\InstanceConfigTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;

abstract class ResultSetExpirationChecker
{
    use InstanceConfigTrait;
    
    protected array $_defaultConfiguration = [
        'field' => 'modified',
        'expiration' => '+1 day',
    ];

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    abstract public function isExpired(ResultSetInterface $entities): bool;

    protected function isEntityExpired(EntityInterface $entity): bool
    {
        $date = $entity->get($this->getConfigOrFail('field'));
        // TODO: Check if $date is actually a date compatible with cakephp's date classes
        
    }
}