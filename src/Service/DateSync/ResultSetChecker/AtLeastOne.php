<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetChecker;

use App\Service\DateSync\ResultSetChecker;
use Cake\Datasource\ResultSetInterface;

class AtLeastOne extends ResultSetChecker
{
    public function isSetExpired(ResultSetInterface $entities): bool
    {
        return $entities->isEmpty() || $entities->some(fn($entity) => $this->isEntityExpired($entity));
    }
}