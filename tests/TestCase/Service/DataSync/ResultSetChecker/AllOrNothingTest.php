<?php

declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync\ResultSetChecker;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use Cake\I18n\Date;
use Cake\ORM\Entity;
use Cake\ORM\ResultSet;
use PHPUnit\Framework\TestCase;

class AllOrNothingTest extends TestCase
{
    public function testIsSetExpired_allAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'last_sync' => Date::now()->subDays(2),
            'foo' => 'FOO',
        ]), range(1, 4));

        $resultSet = new ResultSet($entities);
        $checker = new AllOrNothing();
        $result = $checker->isSetExpired($resultSet);
        $this->assertTrue($result);
    }

    public function testIsSetExpired_noneAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'last_sync' => Date::now(),
            'foo' => 'FOO',
        ]), range(1, 4));

        $resultSet = new ResultSet($entities);
        $checker = new AllOrNothing();
        $result = $checker->isSetExpired($resultSet);
        $this->assertFalse($result);
    }

    public function testIsSetExpired_someAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'last_sync' => Date::now(),
            'foo' => 'FOO',
        ]), range(1, 4));
        $entities[] = new Entity([
            'id' => 5,
            'last_sync' => Date::now()->subDays(2),
            'foo' => 'FOO',
        ]);

        $resultSet = new ResultSet($entities);
        $checker = new AllOrNothing();
        $result = $checker->isSetExpired($resultSet);
        $this->assertFalse($result);
    }

    public function testIsSetExpired_emptySet(): void
    {
        $resultSet = new ResultSet([]);
        $checker = new AllOrNothing();
        $result = $checker->isSetExpired($resultSet);
        $this->assertTrue($result);
    }
}