<?php

declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync;

use App\Service\DateSync\EntityExpirationChecker;
use Cake\I18n\Date;
use Cake\ORM\Entity;
use PHPUnit\Framework\TestCase;

class EntityExpirationCheckerTest extends TestCase
{
    public function testIsEntityExpired_entityIsExpired(): void
    {
        $entityExpirationChecker = new EntityExpirationChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('modified')
            ->willReturn(Date::now()->subDays(2));
        $this->assertTrue($entityExpirationChecker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityExpiresToday(): void
    {
        $entityExpirationChecker = new EntityExpirationChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('modified')
            ->willReturn(Date::now()->subDays(1));
        $this->assertTrue($entityExpirationChecker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityNotExpired_extendExpiration1Week(): void
    {
        $entityExpirationChecker = new EntityExpirationChecker([
            'interval' => 'P7D',
        ]);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('modified')
            ->willReturn(Date::now()->subDays(5));
        $this->assertFalse($entityExpirationChecker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityExpired_extendExpiration1Week(): void
    {
        $entityExpirationChecker = new EntityExpirationChecker([
            'interval' => 'P7D',
        ]);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('modified')
            ->willReturn(Date::now()->subDays(7));
        $this->assertTrue($entityExpirationChecker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityIsNotExpired(): void
    {
        $entityExpirationChecker = new EntityExpirationChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('modified')
            ->willReturn(Date::now());
        $this->assertFalse($entityExpirationChecker->isEntityExpired($mockEntity));
    }
}