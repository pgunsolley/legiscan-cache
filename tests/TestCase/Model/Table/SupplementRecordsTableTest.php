<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupplementRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupplementRecordsTable Test Case
 */
class SupplementRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SupplementRecordsTable
     */
    protected $SupplementRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SupplementRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SupplementRecords') ? [] : ['className' => SupplementRecordsTable::class];
        $this->SupplementRecords = $this->getTableLocator()->get('SupplementRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SupplementRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SupplementRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
