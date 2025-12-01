<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillRecordsTable Test Case
 */
class BillRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BillRecordsTable
     */
    protected $BillRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecords',
        'app.BillRecordAmendments',
        'app.BillRecordCalendars',
        'app.BillRecordCommittees',
        'app.BillRecordHistories',
        'app.BillRecordProgresses',
        'app.BillRecordReferrals',
        'app.BillRecordSasts',
        'app.BillRecordSessions',
        'app.BillRecordSponsors',
        'app.BillRecordSubjects',
        'app.BillRecordSupplements',
        'app.BillRecordTexts',
        'app.BillRecordVotes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BillRecords') ? [] : ['className' => BillRecordsTable::class];
        $this->BillRecords = $this->getTableLocator()->get('BillRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\BillRecordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
