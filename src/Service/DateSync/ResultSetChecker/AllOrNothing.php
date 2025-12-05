<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetChecker;

use App\Service\DateSync\ResultSetChecker;
use Cake\Datasource\ResultSetInterface;

class AllOrNothing extends ResultSetChecker
{
    public function isSetExpired(ResultSetInterface $entities): bool
    {
        return $entities->every(fn($entity) => $this->isEntityExpired($entity));
    }
}