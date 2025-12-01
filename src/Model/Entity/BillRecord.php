<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BillRecord Entity
 *
 * @property int $id
 * @property int|null $bill_id
 * @property string|null $change_hash
 * @property int|null $session_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $completed
 * @property int|null $status
 * @property \Cake\I18n\Date|null $status_date
 * @property string|null $state
 * @property int|null $state_id
 * @property string|null $bill_number
 * @property string|null $bill_type
 * @property string|null $bill_type_id
 * @property string|null $body
 * @property int|null $body_id
 * @property string|null $current_body
 * @property int|null $current_body_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $pending_committee_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\BillRecordAmendment[] $bill_record_amendments
 * @property \App\Model\Entity\BillRecordCalendar[] $bill_record_calendars
 * @property \App\Model\Entity\BillRecordCommittee[] $bill_record_committees
 * @property \App\Model\Entity\BillRecordHistory[] $bill_record_histories
 * @property \App\Model\Entity\BillRecordProgress[] $bill_record_progresses
 * @property \App\Model\Entity\BillRecordReferral[] $bill_record_referrals
 * @property \App\Model\Entity\BillRecordSast[] $bill_record_sasts
 * @property \App\Model\Entity\BillRecordSession $bill_record_session
 * @property \App\Model\Entity\BillRecordSponsor[] $bill_record_sponsors
 * @property \App\Model\Entity\BillRecordSubject[] $bill_record_subjects
 * @property \App\Model\Entity\BillRecordSupplement[] $bill_record_supplements
 * @property \App\Model\Entity\BillRecordText[] $bill_record_texts
 * @property \App\Model\Entity\BillRecordVote[] $bill_record_votes
 */
class BillRecord extends Entity
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
        'bill_id' => true,
        'change_hash' => true,
        'session_id' => true,
        'url' => true,
        'state_link' => true,
        'completed' => true,
        'status' => true,
        'status_date' => true,
        'state' => true,
        'state_id' => true,
        'bill_number' => true,
        'bill_type' => true,
        'bill_type_id' => true,
        'body' => true,
        'body_id' => true,
        'current_body' => true,
        'current_body_id' => true,
        'title' => true,
        'description' => true,
        'pending_committee_id' => true,
        'created' => true,
        'modified' => true,
        'bill_record_amendments' => true,
        'bill_record_calendars' => true,
        'bill_record_committees' => true,
        'bill_record_histories' => true,
        'bill_record_progresses' => true,
        'bill_record_referrals' => true,
        'bill_record_sasts' => true,
        'bill_record_session' => true,
        'bill_record_sponsors' => true,
        'bill_record_subjects' => true,
        'bill_record_supplements' => true,
        'bill_record_texts' => true,
        'bill_record_votes' => true,
    ];
}
