<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordHistory Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property \Cake\I18n\Date|null $date
 * @property string|null $action
 * @property string|null $chamber
 * @property int|null $chamber_id
 * @property int|null $importance
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 */
class BillRecordHistory extends Entity
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
        'date' => true,
        'action' => true,
        'chamber' => true,
        'chamber_id' => true,
        'importance' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];
}
