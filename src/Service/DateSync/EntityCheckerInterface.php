<?php

namespace App\Service\DateSync;

use Cake\Datasource\EntityInterface;

interface EntityCheckerInterface
{
    public function isEntityExpired(EntityInterface $entity): bool;
}
