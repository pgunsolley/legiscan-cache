<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSast Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $type_id
 * @property string|null $type
 * @property string|null $sast_bill_number
 * @property int|null $sast_bill_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 */
class BillRecordSast extends Entity
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
        'type_id' => true,
        'type' => true,
        'sast_bill_number' => true,
        'sast_bill_id' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];
}
