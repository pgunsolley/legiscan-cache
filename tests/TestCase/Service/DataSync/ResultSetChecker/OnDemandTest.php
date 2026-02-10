<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync\ResultSetChecker;

use App\Service\DataSync\ResultSetChecker\OnDemand;
use Cake\ORM\Entity;
use Cake\ORM\ResultSet;
use PHPUnit\Framework\TestCase;

class OnDemandTest extends TestCase
{
    public function testIsSetExpired(): void
    {
        $checker = new OnDemand();
        $this->assertTrue($checker->isSetExpired(new ResultSet([])));
    }
}