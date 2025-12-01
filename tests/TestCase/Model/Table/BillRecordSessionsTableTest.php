<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordSessionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordSessionsTable Test Case
 */
class BillRecordSessionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordSessionsTable
     */
    protected $BillRecordSessions;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordSessions',
        'app.BillRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BillRecordSessions') ? [] : ['className' => BillRecordSessionsTable::class];
        $this->BillRecordSessions = $this->getTableLocator()->get('BillRecordSessions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordSessions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordSessionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BillRecordSessionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
