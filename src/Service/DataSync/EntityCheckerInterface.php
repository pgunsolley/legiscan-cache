<?php

namespace App\Service\DataSync;

use Cake\Datasource\EntityInterface;

interface EntityCheckerInterface
{
    public function getField(): string;

    public function isEntityExpired(EntityInterface $entity): bool;
}
