<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordCommitteesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordCommitteesTable Test Case
 */
class BillRecordCommitteesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordCommitteesTable
     */
    protected $BillRecordCommittees;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordCommittees',
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
        $config = $this->getTableLocator()->exists('BillRecordCommittees') ? [] : ['className' => BillRecordCommitteesTable::class];
        $this->BillRecordCommittees = $this->getTableLocator()->get('BillRecordCommittees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordCommittees);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordCommitteesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BillRecordCommitteesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
