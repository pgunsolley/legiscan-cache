<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordAmendment Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $amendment_id
 * @property int|null $adopted
 * @property string|null $chamber
 * @property int|null $chamber_id
 * @property \Cake\I18n\Date|null $date
 * @property string|null $title
 * @property string|null $description
 * @property string|null $mime
 * @property int|null $mime_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $amendment_size
 * @property string|null $amendment_hash
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 * @property \App\Model\Entity\AmendmentRecord $amendment_record
 */
class BillRecordAmendment extends Entity
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
        'amendment_id' => true,
        'adopted' => true,
        'chamber' => true,
        'chamber_id' => true,
        'date' => true,
        'title' => true,
        'description' => true,
        'mime' => true,
        'mime_id' => true,
        'url' => true,
        'state_link' => true,
        'amendment_size' => true,
        'amendment_hash' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];
}
