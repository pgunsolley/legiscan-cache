<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordCalendarsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordCalendarsTable Test Case
 */
class BillRecordCalendarsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordCalendarsTable
     */
    protected $BillRecordCalendars;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordCalendars',
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
        $config = $this->getTableLocator()->exists('BillRecordCalendars') ? [] : ['className' => BillRecordCalendarsTable::class];
        $this->BillRecordCalendars = $this->getTableLocator()->get('BillRecordCalendars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordCalendars);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordCalendarsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BillRecordCalendarsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
