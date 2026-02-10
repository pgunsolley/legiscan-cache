<?php

declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync;

use App\Service\DataSync\EntityChecker;
use Cake\I18n\Date;
use Cake\ORM\Entity;
use PHPUnit\Framework\TestCase;
use TypeError;

class EntityCheckerTest extends TestCase
{
    public function testIsEntityExpired_entityIsMissingTargetField(): void
    {
        $checker = new EntityChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(null);
        $this->expectException(TypeError::class);
        $checker->isEntityExpired($mockEntity);
    }

    public function testIsEntityExpired_entityIsExpired(): void
    {
        $checker = new EntityChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(Date::now()->subDays(2));
        $this->assertTrue($checker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityExpiresToday(): void
    {
        $checker = new EntityChecker([
            'interval' => 'P1D',
        ]);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(Date::now()->subDays(1));
        $this->assertTrue($checker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityNotExpired_extendExpiration1Week(): void
    {
        $checker = new EntityChecker([
            'interval' => 'P7D',
        ]);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(Date::now()->subDays(5));
        $this->assertFalse($checker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityExpired_extendExpiration1Week(): void
    {
        $checker = new EntityChecker([
            'interval' => 'P7D',
        ]);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(Date::now()->subDays(7));
        $this->assertTrue($checker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_entityIsNotExpired(): void
    {
        $checker = new EntityChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(Date::now());
        $this->assertFalse($checker->isEntityExpired($mockEntity));
    }

    public function testIsEntityExpired_targetFieldNotValidDateTime_throwTypeError(): void
    {
        $checker = new EntityChecker();
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->expects($this->once())
            ->method('get')
            ->with('last_sync')
            ->willReturn(null);
        $this->expectException(TypeError::class);
        $checker->isEntityExpired($mockEntity);
    }

    public function testGetField(): void
    {
        $this->assertEquals('last_sync', (new EntityChecker())->getField());
    }
}