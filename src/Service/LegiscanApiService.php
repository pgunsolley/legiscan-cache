<?php

declare(strict_types=1);

namespace App\Service;

use Cake\Http\Client;
use Cake\Log\Log;

class LegiscanApiService
{
    protected string $key;

    protected Client $client;

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->client = new Client([
            'host' => 'api.legiscan.com',
            'scheme' => 'https',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getSessionList(string $state): array
    {
        Log::info("Fetching new session list for state $state");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getSessionList',
            'state' => $state,
        ]);

        return $res->getJson() ?? [];
    }

    public function getMasterList(int $sessionId): array
    {
        Log::info("Fetching new master list for session id $sessionId");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getMasterList',
            'id' => $sessionId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getBill(int $billId): array
    {
        Log::info("Fetching new bill for bill id $billId");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getBill',
            'id' => $billId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getBillText(int $docId): array
    {
        Log::info("Fetching new bill text for doc id $docId");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getBillText',
            'id' => $docId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getAmendment(int $amendmentId): array
    {
        Log::info("Fetching new amendment for amendment id $amendmentId");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getAmendment',
            'id' => $amendmentId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getSupplement(int $supplementId): array
    {
        Log::info("Fetching new supplement for supplement id $supplementId");
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getSupplement',
            'id' => $supplementId,
        ]);

        return $res->getJson() ?? [];
    }
}