<?php
/**
 * @var \App\Model\Entity\AmendmentRecord $data
 */

echo json_encode([
    'status' => 'OK',
    'amendment' => [
        'amendment_id' => $data->amendment_id,
        'bill_id' => $data->bill_id,
        'adopted' => $data->adopted,
        'chamber' => $data->chamber,
        'chamber_id' => $data->chamber_id,
        'date' => $data->date->toIso8601String(),
        'title' => $data->title,
        'description' => $data->description,
        'mime' => $data->mime,
        'mime_id' => $data->mime_id,
        'url' => $data->url,
        'state_link' => $data->state_link,
        'amendment_size' => $data->amendment_size,
        'amendment_hash' => $data->amendment_hash,
        'doc' => $data->doc,
        'alt_amendment' => $data->alt_amendment,
        'alt_mime' => $data->alt_mime,
        'alt_mime_id' => $data->alt_mime_id,
        'alt_state_link' => $data->alt_state_link,
        'alt_amendment_size' => $data->alt_amendment_size,
        'alt_amendment_hash' => $data->alt_amendment_hash,
        'alt_doc' => $data->alt_doc,
    ],
]);
