<?php

declare(strict_types=1);

namespace App\Service;

use Cake\Http\Client;

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
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getSessionList',
            'state' => $state,
        ]);

        return $res->getJson() ?? [];
    }

    public function getMasterList(int $sessionId): array
    {
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getMasterList',
            'id' => $sessionId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getBill(int $billId): array
    {
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getBill',
            'id' => $billId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getBillText(int $docId): array
    {
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getBillText',
            'id' => $docId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getAmendment(int $amendmentId): array
    {
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getAmendment',
            'id' => $amendmentId,
        ]);

        return $res->getJson() ?? [];
    }

    public function getSupplement(int $supplementId): array
    {
        $res = $this->client->get('', [
            'key' => $this->key,
            'op' => 'getSupplement',
            'id' => $supplementId,
        ]);

        return $res->getJson() ?? [];
    }
}