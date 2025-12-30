<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSupplement Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $supplement_id
 * @property \Cake\I18n\Date|null $date
 * @property string|null $type
 * @property int|null $type_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $mime
 * @property int|null $mime_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $supplement_size
 * @property string|null $supplement_hash
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 * @property \App\Model\Entity\SupplementRecord $supplement_record
 */
class BillRecordSupplement extends Entity
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
        'bill_record_id' => true,
        'supplement_id' => true,
        'date' => true,
        'type' => true,
        'type_id' => true,
        'title' => true,
        'description' => true,
        'mime' => true,
        'mime_id' => true,
        'url' => true,
        'state_link' => true,
        'supplement_size' => true,
        'supplement_hash' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];
}
