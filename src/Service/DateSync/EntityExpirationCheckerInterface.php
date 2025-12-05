<?php

namespace App\Service\DateSync;

use Cake\Datasource\EntityInterface;

interface EntityExpirationCheckerInterface
{
    public function isEntityExpired(EntityInterface $entity): bool;
}
