<?php

declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\LegiscanApiService;
use Cake\Http\TestSuite\HttpClientTrait;
use Cake\TestSuite\TestCase;

class LegiscanApiServiceTest extends TestCase
{
    use HttpClientTrait;

    protected LegiscanApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LegiscanApiService(
            key: 'foobar',
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->cleanupMockResponses();
    }

    public function testGetSessionList(): void
    {
        $expectedData = ['foo' => 'bar'];
        $state = 'AZ';

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getSessionList&state=$state",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getSessionList(state: $state);
        $this->assertEquals($expectedData, $res);
    }

    public function testGetMasterList(): void
    {
        $expectedData = ['foo' => 'bar'];
        $sessionId = 1337;

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getMasterList&id=$sessionId",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getMasterList(sessionId: $sessionId);
        $this->assertEquals($expectedData, $res);
    }

    public function testGetBill(): void
    {
        $expectedData = ['foo' => 'bar'];
        $billId = 1337;

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getBill&id=$billId",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getBill(billId: $billId);
        $this->assertEquals($expectedData, $res);
    }

    public function testGetBillText(): void
    {
        $expectedData = ['foo' => 'bar'];
        $docId = 1337;

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getBillText&id=$docId",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getBillText(docId: $docId);
        $this->assertEquals($expectedData, $res);
    }

    public function testGetAmendment(): void
    {
        $expectedData = ['foo' => 'bar'];
        $amendmentId = 1337;

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getAmendment&id=$amendmentId",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getAmendment(amendmentId: $amendmentId);
        $this->assertEquals($expectedData, $res);
    }

    public function testGetSupplement(): void
    {
        $expectedData = ['foo' => 'bar'];
        $supplementId = 1337;

        $this->mockClientGet(
            "https://api.legiscan.com/?key=foobar&op=getSupplement&id=$supplementId",
            $this->newClientResponse(
                200,
                [
                    'Content-Type: application/json',
                ],
                json_encode($expectedData),
            ),
        );

        $res = $this->service->getSupplement(supplementId: $supplementId);
        $this->assertEquals($expectedData, $res);
    }
}