<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetExpirationChecker;

use App\Service\DateSync\ResultSetExpirationChecker;
use Cake\Datasource\ResultSetInterface;

class AllOrNothing extends ResultSetExpirationChecker
{
    public function isExpired(ResultSetInterface $entities): bool
    {
        return $entities->every(fn($entity) => $this->isEntityExpired($entity));
    }
}