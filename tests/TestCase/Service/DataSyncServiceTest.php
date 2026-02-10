<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

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
        $state = StateAbbreviation::Alabama;

        $stubLegiscanApiService = $this->createStub(LegiscanApiService::class);
        $stubLegiscanApiService
            ->method('getSessionList')
            ->with($state)
            ->willReturn([
                // TODO: Write fixture
            ]);

        $stubResultSet = $this->createStub(ResultSet::class);

        $stubSelectQuery = $this->createStub(SelectQuery::class);
        $stubSelectQuery
            ->method('select')
            ->with()
            ->willReturn($stubSelectQuery);
        $stubSelectQuery
            ->method('where')
            ->with(['state_abbr' => $state])
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