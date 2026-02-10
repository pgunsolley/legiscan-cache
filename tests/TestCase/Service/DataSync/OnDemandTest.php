<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync;

use App\Service\DataSync\OnDemand;
use Cake\ORM\Entity;
use PHPUnit\Framework\TestCase;

class OnDemandTest extends TestCase
{
    public function testIsEntityExpired(): void
    {
        $checker = new OnDemand();
        $this->assertTrue($checker->isEntityExpired(new Entity()));
    }
}