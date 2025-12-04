<?php

declare(strict_types=1);

namespace App\Service\DateSync;

use Cake\Datasource\ResultSetInterface;

// TODO: Refactor this so that it's a universal interface for all ExpirationCheckers (not just for ResultSetInterface)
interface ResultSetExpirationCheckerInterface
{
    public function isExpired(ResultSetInterface $entities): bool;
}