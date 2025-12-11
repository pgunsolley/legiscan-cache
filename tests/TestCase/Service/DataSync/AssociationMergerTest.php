<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service\DataSync;

use App\Service\DataSync\AssociationMerger;
use Cake\ORM\Association;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Entity;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Table;
use Exception;
use PHPUnit\Framework\TestCase;

class AssociationMergerTest extends TestCase
{
    public function testMergeOneToOne_pass_noExistingAssociatedEntity_associatedIsSet(): void
    {
        $tableName = 'Foos';
        $associationName = 'Bars';
        $associationPropertyName = 'bar';
        $stubAssociatedEntity = $this->createMock(Entity::class);
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
        $stubAssociation = $this->createStub(HasMany::class);
        $stubAssociation
            ->method('getProperty')
            ->willReturn($associationPropertyName);
        $stubAssociation
            ->method('type')
            ->willReturn(Association::ONE_TO_ONE);
        $stubAssociation
            ->method('__call')
            ->willReturnCallback(fn($methodName, $data) => match ($methodName) {
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

        $this->assertInstanceOf(Entity::class, $res);
    }
}