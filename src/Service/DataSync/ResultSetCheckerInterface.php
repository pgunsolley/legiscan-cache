<?php

declare(strict_types=1);

namespace App\Service\DataSync;

use Cake\Datasource\ResultSetInterface;

interface ResultSetCheckerInterface extends EntityCheckerInterface
{
    public function isSetExpired(ResultSetInterface $entities): bool;
}