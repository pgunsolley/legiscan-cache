<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PickComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\PickComponent Test Case
 */
class PickComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\PickComponent
     */
    protected $Pick;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Pick = new PickComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pick);

        parent::tearDown();
    }
}
