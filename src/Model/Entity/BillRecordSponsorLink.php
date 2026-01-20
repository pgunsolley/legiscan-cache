<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSponsorLink Entity
 *
 * @property int $id
 * @property int $bill_record_sponsor_id
 * @property \App\Model\Enum\BillRecordSponsorLinkType $bill_record_sponsor_link_type
 * @property string|null $bluesky
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $tiktok
 * @property string|null $twitter
 * @property string|null $website
 * @property string|null $youtube
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecordSponsor $bill_record_sponsor
 */
class BillRecordSponsorLink extends Entity
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
        'bill_record_sponsor_link_type' => true,
        'bluesky' => true,
        'facebook' => true,
        'instagram' => true,
        'linkedin' => true,
        'tiktok' => true,
        'twitter' => true,
        'website' => true,
        'youtube' => true,
        'created' => true,
        'modified' => true,
        'bill_record_sponsor' => true,
    ];
}
