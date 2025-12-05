<?php

declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync\ResultSetExpirationChecker;

use App\Service\DateSync\ResultSetExpirationChecker\AtLeastOne;
use Cake\I18n\Date;
use Cake\ORM\Entity;
use Cake\ORM\ResultSet;
use PHPUnit\Framework\TestCase;

class AtLeastOneTest extends TestCase
{
    public function testIsSetExpired_allAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'modified' => Date::now()->subDays(2),
            'foo' => 'FOO',
        ]), range(1, 4));

        $resultSet = new ResultSet($entities);
        $checker = new AtLeastOne();
        $result = $checker->isSetExpired($resultSet);
        $this->assertTrue($result);
    }

    public function testIsSetExpired_noneAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'modified' => Date::now(),
            'foo' => 'FOO',
        ]), range(1, 4));

        $resultSet = new ResultSet($entities);
        $checker = new AtLeastOne();
        $result = $checker->isSetExpired($resultSet);
        $this->assertFalse($result);
    }

    public function testIsSetExpired_someAreExpired(): void
    {
        $entities = array_map(fn($i) => new Entity([
            'id' => $i,
            'modified' => Date::now(),
            'foo' => 'FOO',
        ]), range(1, 4));
        $entities[] = new Entity([
            'id' => 5,
            'modified' => Date::now()->subDays(2),
            'foo' => 'FOO',
        ]);

        $resultSet = new ResultSet($entities);
        $checker = new AtLeastOne();
        $result = $checker->isSetExpired($resultSet);
        $this->assertTrue($result);
    }
}