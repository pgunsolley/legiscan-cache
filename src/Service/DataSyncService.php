<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\DataSync\Exception\InvalidResponseBodyException;
use App\Service\DataSync\ResultSetCheckerInterface;
use App\Utility\StateAbbreviation;
use Cake\Http\Exception\NotImplementedException;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;

class DataSyncService
{
    use LocatorAwareTrait;

    protected LegiscanApiService $legiscanApiService;

    public function __construct(LegiscanApiService $legiscanApiService)
    {
        $this->legiscanApiService = $legiscanApiService;
    }

    public function syncSessionList(StateAbbreviation $state, ResultSetCheckerInterface $checker): array
    {
        $table = $this->fetchTable('SessionListRecords');
        $entities = $table->find('byStateAbbreviation', stateAbbreviation: $state)->all();

        if (!$checker->isSetExpired($entities)) {
            return [];
        }

        $apiResponseBody = $this->legiscanApiService->getSessionList($state->value);
        if (!array_key_exists('sessions', $apiResponseBody)) {
            throw new InvalidResponseBodyException("getSessionList response body missing key 'sessions'");
        }

        $sessionList = $apiResponseBody['sessions'];

        foreach ($sessionList as $sessionListItem) {
            /** @var \App\Model\Entity\SessionListRecord $entity */
            $entity = $entities->firstMatch([
                'session_id' => $sessionListItem['session_id'],
                'state_id' => $sessionListItem['state_id'],
                'state_abbr' => $sessionListItem['state_abbr'],
                'year_start' => $sessionListItem['year_start'],
                'year_end' => $sessionListItem['year_end'],
                'session_tag' => $sessionListItem['session_tag'],
                'session_title' => $sessionListItem['session_title'],
                'session_name' => $sessionListItem['session_name'],
            ]) ?? $table->newEntity($sessionListItem);

            if (!$entity->isNew()) {
                $entity->set($checker->getField(), Date::now());
            }

            // TODO: 
        }
    }

    public function syncMasterList(int $sessionId, ResultSetCheckerInterface $checker): void
    {
        throw new NotImplementedException();
    }
}