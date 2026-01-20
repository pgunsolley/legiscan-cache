<?php
/**
 * @var \App\Model\Entity\BillTextRecord $data
 */

echo json_encode([
    'status' => 'OK',
    'text' => [
        'doc_id' => $data->doc_id,
        'bill_id' => $data->bill_id,
        'date' => $data->date->toIso8601String(),
        'type' => $data->type,
        'type_id' => $data->type_id,
        'mime' => $data->mime,
        'mime_id' => $data->mime_id,
        'url' => $data->url,
        'state_link' => $data->state_link,
        'text_size' => $data->text_size,
        'text_hash' => $data->text_hash,
        'doc' => $data->doc,
        'alt_bill_text' => $data->alt_bill_text,
        'alt_mime' => $data->alt_mime,
        'alt_mime_id' => $data->alt_mime_id,
        'alt_state_link' => $data->alt_state_link,
        'alt_text_size' => $data->alt_text_size,
        'alt_text_hash' => $data->alt_text_hash,
        'alt_doc' => $data->alt_doc,
    ],
]);
