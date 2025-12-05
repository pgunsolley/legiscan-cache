<?php

declare(strict_types=1);

namespace App\Service\DateSync\ResultSetChecker;

use App\Service\DateSync\EntityChecker;
use App\Service\DateSync\ResultSetCheckerInterface;
use Cake\Datasource\ResultSetInterface;

class AtLeastOne extends EntityChecker implements ResultSetCheckerInterface
{
    public function isSetExpired(ResultSetInterface $entities): bool
    {
        return $entities->some(fn($entity) => $this->isEntityExpired($entity));
    }
}