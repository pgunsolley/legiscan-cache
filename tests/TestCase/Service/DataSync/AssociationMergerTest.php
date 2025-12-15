<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync;

use App\Service\DataSync\AssociationMerger;
use Cake\ORM\Association;
use Cake\ORM\Association\HasOne;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Table;
use Exception;
use PHPUnit\Framework\TestCase;

class AssociationMergerTest extends TestCase
{
    public function testMergeOneToOne_noExistingAssociatedEntity(): void
    {
        $tableName = 'Foos';
        $associationName = 'Bars';
        $associationPropertyName = 'bar';
        $stubAssociatedEntity = $this->createStub(Entity::class);
        $stubAssociatedEntity
            ->method('isNew')
            ->with()
            ->willReturn(true);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->method('getSource')
            ->with()
            ->willReturn($tableName);
        $mockEntity
            ->method('get')
            ->with($associationPropertyName)
            ->willReturn(null);
        $mockEntity
            ->expects($this->once())
            ->method('set')
            ->with($associationPropertyName, $stubAssociatedEntity);
        $stubAssociation = $this->createStub(HasOne::class);
        $stubAssociation
            ->method('getProperty')
            ->willReturn($associationPropertyName);
        $stubAssociation
            ->method('type')
            ->willReturn(Association::ONE_TO_ONE);
        $stubAssociation
            ->method('__call')
            ->willReturnCallback(fn($methodName) => match ($methodName) {
                'newEmptyEntity' => $stubAssociatedEntity,
                'patchEntity' => null,
                default => throw new Exception("Method $methodName not expected"),
            });
        $stubTable = $this->createStub(Table::class);
        $stubTable
            ->method('getAssociation')
            ->with($associationName)
            ->willReturn($stubAssociation);
        $stubTableLocator = $this->createStub(TableLocator::class);
        $stubTableLocator
            ->method('get')
            ->with($tableName, [])
            ->willReturn($stubTable);

        $merger = new AssociationMerger($mockEntity);
        $merger->setTableLocator($stubTableLocator);
        $res = $merger->mergeOneToOne(
            associationName: $associationName,
            data: [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        );

        $this->assertEquals($stubAssociatedEntity, $res);
    }

    public function testMergeOneToOne_existingAssociatedEntity(): void
    {
        $tableName = 'Foos';
        $associationName = 'Bars';
        $associationPropertyName = 'bar';
        $stubAssociatedEntity = $this->createStub(Entity::class);
        $stubAssociatedEntity
            ->method('isNew')
            ->with()
            ->willReturn(false);
        $mockEntity = $this->createMock(Entity::class);
        $mockEntity
            ->method('getSource')
            ->with()
            ->willReturn($tableName);
        $mockEntity
            ->method('get')
            ->with($associationPropertyName)
            ->willReturn($stubAssociatedEntity);
        $mockEntity
            ->expects($this->never())
            ->method('set');
        $stubAssociation = $this->createStub(HasOne::class);
        $stubAssociation
            ->method('getProperty')
            ->willReturn($associationPropertyName);
        $stubAssociation
            ->method('type')
            ->willReturn(Association::ONE_TO_ONE);
        $stubTable = $this->createStub(Table::class);
        $stubTable
            ->method('getAssociation')
            ->with($associationName)
            ->willReturn($stubAssociation);
        $stubTableLocator = $this->createStub(TableLocator::class);
        $stubTableLocator
            ->method('get')
            ->with($tableName, [])
            ->willReturn($stubTable);

        $merger = new AssociationMerger($mockEntity);
        $merger->setTableLocator($stubTableLocator);
        $res = $merger->mergeOneToOne(
            associationName: $associationName,
            data: [
                'foo' => 'bar',
                'bar' => 'baz',
            ],
        );

        $this->assertEquals($stubAssociatedEntity, $res);
    }

    public function testMergeOneToOne_descend1Level_noExistingAssociatedEntities(): void
    {
        $table1Name = 'Foos';
        $association1Name = 'Bars';
        $association2Name = 'Bazs';
        $association1PropertyName = 'bar';
        $association2PropertyName = 'baz';

        $expectedData = [
            'id' => 'BAR',
            'baz' => [
                'id' => 'BAZ',
            ],
        ];

        $stubAssociated2Entity = $this->createStub(Entity::class);
        $stubAssociated2Entity
            ->method('isNew')
            ->with()
            ->willReturn(true);

        $stubAssociated1Entity = $this->createStub(Entity::class);
        $stubAssociated1Entity
            ->method('isNew')
            ->with()
            ->willReturn(true);
        $stubAssociated1Entity
            ->method('getSource')
            ->with()
            ->willReturn($association1Name);
        $stubAssociated1Entity
            ->method('get')
            ->with($association2PropertyName)
            ->willReturn($stubAssociated2Entity);

        $stubEntity = $this->createMock(Entity::class);
        $stubEntity
            ->method('getSource')
            ->with()
            ->willReturn($table1Name);
        $stubEntity
            ->method('get')
            ->with($association1PropertyName)
            ->willReturn($stubAssociated1Entity);

        $stubAssociation2 = $this->createStub(HasOne::class);
        $stubAssociation2
            ->method('getProperty')
            ->willReturn($association2PropertyName);
        $stubAssociation2
            ->method('type')
            ->willReturn(Association::ONE_TO_ONE);

        $stubAssociation1 = $this->createStub(HasOne::class);
        $stubAssociation1
            ->method('getProperty')
            ->willReturn($association1PropertyName);
        $stubAssociation1
            ->method('type')
            ->willReturn(Association::ONE_TO_ONE);

        $stubTable1 = $this->createStub(Table::class);
        $stubTable1
            ->method('getAssociation')
            ->with($association1Name)
            ->willReturn($stubAssociation1);

        $stubTable2 = $this->createStub(Table::class);
        $stubTable2
            ->method('getAssociation')
            ->with($association2Name)
            ->willReturn($stubAssociation2);

        $stubTableLocator1 = $this->createStub(TableLocator::class);
        $stubTableLocator1
            ->method('get')
            ->with($table1Name, [])
            ->willReturn($stubTable1);

        $stubTableLocator2 = $this->createStub(TableLocator::class);
        $stubTableLocator2
            ->method('get')
            ->with($association1Name)
            ->willReturn($stubTable2);

        $merger = new AssociationMerger($stubEntity);
        $merger->setTableLocator($stubTableLocator1);
        $res = $merger->mergeOneToOne(
            associationName: $association1Name,
            data: $expectedData,
            descend: function (AssociationMerger $merger, array $data) use (
                $association2Name,
                $association2PropertyName,
                $stubTableLocator2,
                $expectedData,
            ) {
                $this->assertEquals($expectedData, $data);
                $merger->setTableLocator($stubTableLocator2);
                $merger->mergeOneToOne($association2Name, $data[$association2PropertyName]);
            },
        );

        $this->assertEquals($stubAssociated1Entity, $res);
    }
}