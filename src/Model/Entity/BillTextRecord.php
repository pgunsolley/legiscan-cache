<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillTextRecord Entity
 *
 * @property int $id
 * @property int|null $doc_id
 * @property int|null $bill_id
 * @property \Cake\I18n\Date|null $date
 * @property string|null $type
 * @property int|null $type_id
 * @property string|null $mime
 * @property int|null $mime_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $text_size
 * @property string|null $text_hash
 * @property string|null $doc
 * @property int|null $alt_bill_text
 * @property string|null $alt_mime
 * @property int|null $alt_mime_id
 * @property string|null $alt_state_link
 * @property int|null $alt_text_size
 * @property string|null $alt_doc
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class BillTextRecord extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'doc_id' => true,
        'bill_id' => true,
        'date' => true,
        'type' => true,
        'type_id' => true,
        'mime' => true,
        'mime_id' => true,
        'url' => true,
        'state_link' => true,
        'text_size' => true,
        'text_hash' => true,
        'doc' => true,
        'alt_bill_text' => true,
        'alt_mime' => true,
        'alt_mime_id' => true,
        'alt_state_link' => true,
        'alt_text_size' => true,
        'alt_doc' => true,
        'created' => true,
        'modified' => true,
    ];
}
