<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecordSponsor Entity
 *
 * @property int $id
 * @property int $bill_record_id
 * @property int|null $people_id
 * @property string|null $person_hash
 * @property string|null $party_id
 * @property int|null $state_id
 * @property string $party
 * @property int|null $role_id
 * @property string|null $role
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $suffix
 * @property string|null $nickname
 * @property string|null $district
 * @property int|null $ftm_eid
 * @property int|null $votesmart_id
 * @property string|null $opensecrets_id
 * @property int|null $knowwho_pid
 * @property string|null $ballotpedia
 * @property string|null $bioguide_id
 * @property int|null $sponsor_type_id
 * @property int|null $sponsor_order
 * @property int|null $committee_sponsor
 * @property int|null $committee_id
 * @property int|null $state_federal
 * @property \App\Model\Entity\BillRecordSponsorSocial|null $bill_record_sponsor_social
 * @property \App\Model\Entity\BillRecordSponsorCapitolAddress|null $bill_record_sponsor_capitol_address
 * @property \App\Model\Entity\BillRecordSponsorLink[]|null $bill_record_sponsor_links
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecord $bill_record
 */
class BillRecordSponsor extends Entity
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
        'people_id' => true,
        'person_hash' => true,
        'party_id' => true,
        'state_id' => true,
        'party' => true,
        'role_id' => true,
        'role' => true,
        'name' => true,
        'first_name' => true,
        'middle_name' => true,
        'last_name' => true,
        'suffix' => true,
        'nickname' => true,
        'district' => true,
        'ftm_eid' => true,
        'votesmart_id' => true,
        'opensecrets_id' => true,
        'knowwho_pid' => true,
        'ballotpedia' => true,
        'bioguide_id' => true,
        'sponsor_type_id' => true,
        'sponsor_order' => true,
        'committee_sponsor' => true,
        'committee_id' => true,
        'state_federal' => true,
        'created' => true,
        'modified' => true,
        'bill_record' => true,
        'bill_record_sponsor_social' => true,
        'bill_record_sponsor_capitol_address' => true,
        'bill_record_sponsor_links' => true,
    ];
}
