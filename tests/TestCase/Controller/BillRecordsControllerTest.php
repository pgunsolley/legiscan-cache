<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\BillRecordsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BillRecordsController Test Case
 *
 * @link \App\Controller\BillRecordsController
 */
class BillRecordsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.MasterListRecords',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\BillRecordsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\BillRecordsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\BillRecordsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\BillRecordsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\BillRecordsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
