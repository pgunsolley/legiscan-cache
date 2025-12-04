<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetExpirationChecker;

use App\Service\DateSync\ResultSetExpirationChecker;
use Cake\Datasource\ResultSetInterface;

class AtLeastOne extends ResultSetExpirationChecker
{
    public function isExpired(ResultSetInterface $entities): bool
    {
        return $entities->some(fn($entity) => $this->isEntityExpired($entity));
    }
}