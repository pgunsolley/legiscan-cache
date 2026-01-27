<?php
/**
 * @var \Cake\Datasource\ResultSetInterface $data
 * @var \Cake\View\JsonView $this
 */

use App\Model\Entity\MasterListRecord;

echo json_encode([
    'status' => 'OK',
    'masterlist' => array_map(fn(MasterListRecord $masterListRecord) => [
        'bill_id' => $masterListRecord->bill_id,
        'number' => $masterListRecord->number,
        'change_hash' => $masterListRecord->change_hash,
        'url' =>  $masterListRecord->url,
        'status_date' => $masterListRecord->status_date?->toIso8601String(),
        'status' => $masterListRecord->status,
        'last_action_date' => $masterListRecord->last_action_date?->toIso8601String(),
        'last_action' => $masterListRecord->last_action,
        'title' => $masterListRecord->title,
        'description' => $masterListRecord->description,
    ], $data->toArray()),
]);
