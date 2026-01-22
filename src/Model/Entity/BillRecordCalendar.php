<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * BillRecordCalendar Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $type_id
 * @property string|null $type
 * @property \Cake\I18n\Date|null $date
 * @property \Cake\I18n\Time|null $time
 * @property string|null $location
 * @property string|null $description
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 */
class BillRecordCalendar extends Entity
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
        'date' => true,
        'time' => true,
        'location' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
    ];

    protected function _setDate(null|string|Date $date): null|string|Date
    {
        if ($date === '0000-00-00') {
            return null;
        }

        return $date;
    }
}
