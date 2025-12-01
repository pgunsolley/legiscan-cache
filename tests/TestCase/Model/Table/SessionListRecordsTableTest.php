<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SessionListRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SessionListRecordsTable Test Case
 */
class SessionListRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SessionListRecordsTable
     */
    protected $SessionListRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SessionListRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SessionListRecords') ? [] : ['className' => SessionListRecordsTable::class];
        $this->SessionListRecords = $this->getTableLocator()->get('SessionListRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SessionListRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SessionListRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
