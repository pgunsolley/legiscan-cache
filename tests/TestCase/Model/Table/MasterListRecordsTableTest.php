<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MasterListRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MasterListRecordsTable Test Case
 */
class MasterListRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MasterListRecordsTable
     */
    protected $MasterListRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.MasterListRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MasterListRecords') ? [] : ['className' => MasterListRecordsTable::class];
        $this->MasterListRecords = $this->getTableLocator()->get('MasterListRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MasterListRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MasterListRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
