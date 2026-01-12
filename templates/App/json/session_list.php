<?php
/**
 * @var \Cake\Datasource\ResultSetInterface $data
 * @var \Cake\View\JsonView $this
 */

use App\Model\Entity\SessionListRecord;

echo json_encode([
    'status' => 'OK',
    'sessions' => array_map(fn(SessionListRecord $sessionListRecord) => [
        'session_id' => $sessionListRecord->session_id,
        'state_id' => $sessionListRecord->state_id,
        'state_abbr' => $sessionListRecord->state_abbr,
        'year_start' => $sessionListRecord->year_start,
        'year_end' => $sessionListRecord->year_end,
        'prefile' => $sessionListRecord->prefile,
        'sine_die' => $sessionListRecord->sine_die,
        'prior' => $sessionListRecord->prior,
        'special' => $sessionListRecord->special,
        'session_tag' => $sessionListRecord->session_tag,
        'session_title' => $sessionListRecord->session_title,
        'session_name' => $sessionListRecord->session_name,
        'dataset_hash' => $sessionListRecord->dataset_hash,
        'session_hash' => $sessionListRecord->session_hash,
        'name' => $sessionListRecord->name,
    ], $data->toArray()),
]);
