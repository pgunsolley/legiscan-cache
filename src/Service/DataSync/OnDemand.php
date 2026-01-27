<?php
declare(strict_types=1);

namespace App\Service\DataSync;

use Cake\Datasource\EntityInterface;

class OnDemand extends EntityChecker
{
    public function isEntityExpired(EntityInterface $entity): bool
    {
        return true;
    }
}