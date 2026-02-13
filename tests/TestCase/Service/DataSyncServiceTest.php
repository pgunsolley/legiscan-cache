<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\DataSync\EntityChecker;
use App\Service\DataSync\ResultSetChecker\AllOrNothing;
use App\Service\LegiscanApiService;
use App\Utility\StateAbbreviation;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\ResultSet;
use Cake\ORM\Table;
use PHPUnit\Framework\TestCase;

class DataSyncServiceTest extends TestCase
{
    public function testSyncSessionList_noExistingEntities_makeRequestToLegiscan_saveNewEntities()
    {
        $usState = StateAbbreviation::Alabama;

        $stubLegiscanApiService = $this->createStub(LegiscanApiService::class);
        $stubLegiscanApiService
            ->method('getSessionList')
            ->with($usState)
            ->willReturn([
                'foo' => 'bar',
            ]);

        $stubResultSet = $this->createStub(ResultSet::class);

        $stubAllOrNothingStrategy = $this->createStub(AllOrNothing::class);
        $stubAllOrNothingStrategy
            ->method('isResultSetExpired')
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
    }
}