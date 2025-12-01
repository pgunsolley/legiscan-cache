<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordCommittee Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $committee_id
 * @property string|null $chamber
 * @property int|null $chamber_id
 * @property string|null $name
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 */
class BillRecordCommittee extends Entity
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
        'committee_id' => true,
        'chamber' => true,
        'chamber_id' => true,
        'name' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];
}
