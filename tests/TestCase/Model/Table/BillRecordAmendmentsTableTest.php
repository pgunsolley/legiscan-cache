<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordAmendmentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordAmendmentsTable Test Case
 */
class BillRecordAmendmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordAmendmentsTable
     */
    protected $BillRecordAmendments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordAmendments',
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
        $config = $this->getTableLocator()->exists('BillRecordAmendments') ? [] : ['className' => BillRecordAmendmentsTable::class];
        $this->BillRecordAmendments = $this->getTableLocator()->get('BillRecordAmendments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordAmendments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordAmendmentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BillRecordAmendmentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
