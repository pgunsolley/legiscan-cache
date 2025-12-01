<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordSastsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordSastsTable Test Case
 */
class BillRecordSastsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordSastsTable
     */
    protected $BillRecordSasts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordSasts',
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
        $config = $this->getTableLocator()->exists('BillRecordSasts') ? [] : ['className' => BillRecordSastsTable::class];
        $this->BillRecordSasts = $this->getTableLocator()->get('BillRecordSasts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordSasts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordSastsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\BillRecordSastsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
