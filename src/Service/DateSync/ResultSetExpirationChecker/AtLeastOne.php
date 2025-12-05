<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetExpirationChecker;

use App\Service\DateSync\EntityExpirationChecker;
use App\Service\DateSync\ResultSetExpirationCheckerInterface;
use Cake\Datasource\ResultSetInterface;

class AtLeastOne extends EntityExpirationChecker implements ResultSetExpirationCheckerInterface
{
    public function isSetExpired(ResultSetInterface $entities): bool
    {
        return $entities->some(fn($entity) => $this->isEntityExpired($entity));
    }
}