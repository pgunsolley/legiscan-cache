<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\DataSyncService;
use App\Service\LegiscanApiService;
use App\Utility\StateAbbreviation;
use Cake\ORM\Locator\TableLocator;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\ResultSet;
use Cake\ORM\Table;
use PHPUnit\Framework\TestCase;

class DataSyncServiceTest extends TestCase
{
    public function testSyncSessionList_noExistingEntities_responseDataMissingSessionsKey_throws()
    {
        $usState = StateAbbreviation::Alabama;

        $stubLegiscanApiService = $this->createMock(LegiscanApiService::class);
        $stubLegiscanApiService
            ->expects($this->once())
            ->method('getSessionList')
            ->with($usState)
            ->willReturn([
                'invalidProp' => 'foobar',
            ]);

        $stubResultSet = $this->createStub(ResultSet::class);

        $stubAllOrNothingStrategy = $this->createStub(AllOrNothing::class);
        $stubAllOrNothingStrategy
            ->method('isSetExpired')
            ->with()
            ->willReturn(false);

        $stubSelectQuery = $this->createStub(SelectQuery::class);
        $stubSelectQuery
            ->method('select')
            ->with()
            ->willReturn($stubSelectQuery);
        $stubSelectQuery
            ->method('where')
            ->with(['state_abbr' => $usState])
            ->willReturn($stubSelectQuery);
        $stubSelectQuery
            ->method('all')
            ->with()
            ->willReturn($stubResultSet);

        $stubTable = $this->createStub(Table::class);
        $stubTable
            ->method('find')
            ->with()
            ->willReturn($stubSelectQuery);

        $stubTableLocator = $this->createStub(TableLocator::class);
        $stubTableLocator
            ->method('get')
            ->with()

        $service = new DataSyncService($stubLegiscanApiService);

        // $service->setTableLocator()
        $service->syncSessionList($usState, $stubAllOrNothingStrategy);
    }
}