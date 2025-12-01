<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AmendmentRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AmendmentRecordsTable Test Case
 */
class AmendmentRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AmendmentRecordsTable
     */
    protected $AmendmentRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.AmendmentRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AmendmentRecords') ? [] : ['className' => AmendmentRecordsTable::class];
        $this->AmendmentRecords = $this->getTableLocator()->get('AmendmentRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AmendmentRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AmendmentRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
