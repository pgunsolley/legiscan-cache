<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\BillRecordAssociationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\BillRecordAssociationComponent Test Case
 */
class BillRecordAssociationComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\BillRecordAssociationComponent
     */
    protected $BillRecordAssociation;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->BillRecordAssociation = new BillRecordAssociationComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BillRecordAssociation);

        parent::tearDown();
    }
}
