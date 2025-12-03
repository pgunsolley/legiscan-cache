<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Rule;

use App\Model\Rule\SingletonRule;
use Cake\ORM\Entity;
use Cake\ORM\Exception\MissingEntityException;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Exception;
use PHPUnit\Framework\TestCase;

class SingletonRuleTest extends TestCase
{
    public function test__invoke_pass_validFieldsAndNoExistingEntity(): void
    {
        $rule = new SingletonRule(fields: ['foo', 'bar']);
        $mockEntity = $this->createMock(Entity::class);
        $mockSelectQuery = $this->createMock(SelectQuery::class);
        $mockTable = $this->createMock(Table::class);

        $mockEntity
            ->expects($this->exactly(2))
            ->method('has')
            ->willReturnCallback(fn($arg) => match ($arg) {
                'foo',
                'bar' => true,
                default => throw new Exception("Unexpected property $arg"),
            });

        $mockEntity
            ->expects($this->once())
            ->method('toArray')
            ->with()
            ->willReturn([
                'foo' => 'FOO',
                'bar' => 'BAR',
            ]);

        $mockEntity
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturnCallback(fn($arg) => match ($arg) {
                'foo' => 'FOO',
                'bar' => 'BAR',
                default => throw new Exception("Unexpected property $arg"),
            });

        $mockSelectQuery
            ->expects($this->once())
            ->method('where')
            ->with([
                'foo' => 'FOO',
                'bar' => 'BAR',
            ])
            ->willReturnSelf();

        $mockSelectQuery
            ->expects($this->once())
            ->method('count')
            ->with()
            ->willReturn(0);

        $mockTable
            ->expects($this->once())
            ->method('find')
            ->with()
            ->willReturn($mockSelectQuery);

        $options = [
            'errorField' => 'foo',
            'message' => 'error-message',
            'repository' => $mockTable,
        ];

        $result = $rule($mockEntity, $options);
        $this->assertTrue($result);
    }

    public function test__invoke_fail_validFieldsAndExistingEntity(): void
    {
        $rule = new SingletonRule(fields: ['foo', 'bar']);
        $mockEntity = $this->createMock(Entity::class);
        $mockSelectQuery = $this->createMock(SelectQuery::class);
        $mockTable = $this->createMock(Table::class);

        $mockEntity
            ->expects($this->exactly(2))
            ->method('has')
            ->willReturnCallback(fn($arg) => match ($arg) {
                'foo',
                'bar' => true,
                default => throw new Exception("Unexpected property $arg"),
            });

        $mockEntity
            ->expects($this->once())
            ->method('toArray')
            ->with()
            ->willReturn([
                'foo' => 'FOO',
                'bar' => 'BAR',
            ]);

        $mockEntity
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturnCallback(fn($arg) => match ($arg) {
                'foo' => 'FOO',
                'bar' => 'BAR',
                default => throw new Exception("Unexpected property $arg"),
            });

        $mockSelectQuery
            ->expects($this->once())
            ->method('where')
            ->with([
                'foo' => 'FOO',
                'bar' => 'BAR',
            ])
            ->willReturnSelf();

        $mockSelectQuery
            ->expects($this->once())
            ->method('count')
            ->with()
            ->willReturn(1);

        $mockTable
            ->expects($this->once())
            ->method('find')
            ->with()
            ->willReturn($mockSelectQuery);

        $options = [
            'errorField' => 'foo',
            'message' => 'error-message',
            'repository' => $mockTable,
        ];

        $result = $rule($mockEntity, $options);
        $this->assertFalse($result);
    }

    public function test__invoke_throws_missingRequiredFieldOnEntity(): void
    {
        $rule = new SingletonRule(fields: ['foo', 'bar', 'baz']);
        $mockEntity = $this->createMock(Entity::class);
        $mockSelectQuery = $this->createMock(SelectQuery::class);
        $mockTable = $this->createMock(Table::class);

        $mockEntity
            ->expects($this->exactly(3))
            ->method('has')
            ->willReturnCallback(fn($arg) => match ($arg) {
                'foo',
                'bar' => true,
                'baz' => false, // Entity does not have 'baz' field set
                default => throw new Exception("Unexpected property $arg"),
            });

        $mockEntity
            ->expects($this->never())
            ->method('toArray');

        $mockEntity
            ->expects($this->never())
            ->method('get');

        $mockSelectQuery
            ->expects($this->never())
            ->method('where');

        $mockSelectQuery
            ->expects($this->never())
            ->method('count');

        $mockTable
            ->expects($this->never())
            ->method('find');

        $options = [
            'errorField' => 'foo',
            'message' => 'error-message',
            'repository' => $mockTable,
        ];

        $this->expectException(MissingEntityException::class);
        $rule($mockEntity, $options);
    }
}
