<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSponsorSocial Entity
 *
 * @property int $id
 * @property int $bill_record_sponsor_id
 * @property string|null $capitol_phone
 * @property string|null $district_phone
 * @property string|null $email
 * @property string|null $webmail
 * @property string|null $biography
 * @property string|null $image
 * @property string|null $ballotpedia
 * @property string|null $votesmart
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecordSponsor $bill_record_sponsor
 */
class BillRecordSponsorSocial extends Entity
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
        'capitol_phone' => true,
        'district_phone' => true,
        'email' => true,
        'webmail' => true,
        'biography' => true,
        'image' => true,
        'ballotpedia' => true,
        'votesmart' => true,
        'created' => true,
        'modified' => true,
        'bill_record_sponsor' => true,
    ];
}
