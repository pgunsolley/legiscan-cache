<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillTextRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillTextRecordsTable Test Case
 */
class BillTextRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillTextRecordsTable
     */
    protected $BillTextRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillTextRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BillTextRecords') ? [] : ['className' => BillTextRecordsTable::class];
        $this->BillTextRecords = $this->getTableLocator()->get('BillTextRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillTextRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillTextRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
