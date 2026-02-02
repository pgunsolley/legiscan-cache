<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\BillRecordSponsorsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BillRecordSponsorsController Test Case
 *
 * @link \App\Controller\BillRecordSponsorsController
 */
class BillRecordSponsorsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BillRecordSponsors',
        'app.BillRecords',
        'app.BillRecordSponsorCapitolAddresses',
        'app.BillRecordSponsorSocials',
        'app.BillRecordSponsorLinks',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\BillRecordSponsorsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\BillRecordSponsorsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\BillRecordSponsorsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\BillRecordSponsorsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\BillRecordSponsorsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
