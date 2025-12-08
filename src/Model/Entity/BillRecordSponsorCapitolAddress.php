<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSponsorCapitolAddress Entity
 *
 * @property int $id
 * @property int $bill_record_sponsor_id
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecordSponsor $bill_record_sponsor
 */
class BillRecordSponsorCapitolAddress extends Entity
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
        'bill_record_sponsor_id' => true,
        'address1' => true,
        'address2' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'created' => true,
        'modified' => true,
        'bill_record_sponsor' => true,
    ];
}
