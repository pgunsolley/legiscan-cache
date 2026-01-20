<?php
/**
 * @var \App\Model\Entity\SupplementRecord $data
 */

echo json_encode([
    'status' => 'OK',
    'supplement' => [
        'supplement_id' => $data->supplement_id,
        'bill_id' => $data->bill_id,
        'date' => $data->date,
        'type_id' => $data->type_id,
        'type' => $data->type,
        'title' => $data->title,
        'description' => $data->description,
        'mime' => $data->mime,
        'mime_id' => $data->mime_id,
        'url' => $data->url,
        'state_link' => $data->state_link,
        'supplement_size' => $data->supplement_size,
        'supplement_hash' => $data->supplement_hash,
        'doc' => $data->doc,
        'alt_supplement' => $data->alt_supplement,
        'alt_mime' => $data->alt_mime,
        'alt_mime_id' => $data->alt_mime_id,
        'alt_state_link' => $data->alt_state_link,
        'alt_supplement_size' => $data->alt_supplement_size,
        'alt_supplement_hash' => $data->alt_supplement_hash,
        'alt_doc' => $data->alt_doc,
    ],
]);
