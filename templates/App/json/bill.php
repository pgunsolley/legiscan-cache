<?php
/**
 * @var \App\Model\Entity\BillRecord $data
 * @var \Cake\View\JsonView $this
 */

use App\Model\Entity\BillRecordAmendment;
use App\Model\Entity\BillRecordCalendar;
use App\Model\Entity\BillRecordCommittee;
use App\Model\Entity\BillRecordHistory;
use App\Model\Entity\BillRecordProgress;
use App\Model\Entity\BillRecordReferral;
use App\Model\Entity\BillRecordSast;
use App\Model\Entity\BillRecordSponsor;
use App\Model\Entity\BillRecordSponsorLink;
use App\Model\Entity\BillRecordSubject;
use App\Model\Entity\BillRecordSupplement;
use App\Model\Entity\BillRecordText;
use App\Model\Entity\BillRecordVote;

echo json_encode([
    'status' => 'OK',
    'bill' => [
        'bill_id' => $data->bill_id,
        'change_hash' => $data->change_hash,
        'session_id' => $data->session_id,
        'session' => [
            'session_id' => $data->bill_record_session->session_id,
            'state_id' => $data->bill_record_session->state_id,
            'year_start' => $data->bill_record_session->year_start,
            'year_end' => $data->bill_record_session->year_end,
            'prefile' => $data->bill_record_session->prefile,
            'sine_die' => $data->bill_record_session->sine_die,
            'prior' => $data->bill_record_session->prior,
            'special' => $data->bill_record_session->special,
            'session_tag' => $data->bill_record_session->session_tag,
            'session_title' => $data->bill_record_session->session_title,
            'session_name' => $data->bill_record_session->session_name,
        ],
        'url' => $data->url,
        'state_link' => $data->state_link,
        'completed' => $data->completed,
        'status' => $data->status,
        'status_date' => $data->status_date?->toIso8601String(),
        'progress' => array_map(fn(BillRecordProgress $billRecordProgress) => [
            'date' => $billRecordProgress->date?->toIso8601String(),
            'event' => $billRecordProgress->event,
        ], $data->bill_record_progresses),
        'state' => $data->state,
        'state_id' => $data->state_id,
        'bill_number' => $data->bill_number,
        'bill_type' => $data->bill_type,
        'bill_type_id' => $data->bill_type_id,
        'body' => $data->body,
        'body_id' => $data->body_id,
        'current_body' => $data->current_body,
        'current_body_id' => $data->current_body_id,
        'title' => $data->title,
        'description' => $data->description,
        'pending_committee_id' => $data->pending_committee_id,
        'committee' => [
            'committee_id' => $data->bill_record_committee->committee_id,
            'chamber' => $data->bill_record_committee->chamber,
            'chamber_id' => $data->bill_record_committee->chamber_id,
            'name' => $data->bill_record_committee->name,
        ],
        'referrals' => array_map(fn(BillRecordReferral $billRecordReferral) => [
            'date' => $billRecordReferral->date?->toIso8601String(),
            'committee_id' => $billRecordReferral->committee_id,
            'chamber' => $billRecordReferral->chamber,
            'chamber_id' => $billRecordReferral->chamber_id,
            'name' => $billRecordReferral->name,
        ], $data->bill_record_referrals),
        'history' => array_map(fn(BillRecordHistory $billRecordHistory) => [
            'date' => $billRecordHistory->date?->toIso8601String(),
            'action' => $billRecordHistory->action,
            'chamber' => $billRecordHistory->chamber,
            'chamber_id' => $billRecordHistory->chamber_id,
            'importance' => $billRecordHistory->importance,
        ], $data->bill_record_histories),
        'sponsors' => array_map(fn(BillRecordSponsor $billRecordSponsor) => [
            'people_id' => $billRecordSponsor->people_id,
            'person_hash' => $billRecordSponsor->person_hash,
            'party_id' => $billRecordSponsor->party_id,
            'state_id' => $billRecordSponsor->state_id,
            'party' => $billRecordSponsor->party,
            'role_id' => $billRecordSponsor->role_id,
            'role' => $billRecordSponsor->role,
            'name' => $billRecordSponsor->name,
            'first_name' => $billRecordSponsor->first_name,
            'middle_name' => $billRecordSponsor->middle_name,
            'last_name' => $billRecordSponsor->last_name,
            'suffix' => $billRecordSponsor->suffix,
            'nickname' => $billRecordSponsor->nickname,
            'district' => $billRecordSponsor->district,
            'ftm_eid' => $billRecordSponsor->ftm_eid,
            'votesmart_id' => $billRecordSponsor->votesmart_id,
            'opensecrets_id' => $billRecordSponsor->opensecrets_id,
            'knowwho_pid' => $billRecordSponsor->knowwho_pid,
            'ballotpedia' => $billRecordSponsor->ballotpedia,
            'bioguide_id' => $billRecordSponsor->bioguide_id,
            'sponsor_type_id' => $billRecordSponsor->sponsor_type_id,
            'sponsor_order' => $billRecordSponsor->sponsor_order,
            'committee_sponsor' => $billRecordSponsor->committee_sponsor,
            'committee_id' => $billRecordSponsor->committee_id,
            'state_federal' => $billRecordSponsor->state_federal,
            'bio' => [
                'social' => [
                    'capitol_phone' => $billRecordSponsor->bill_record_sponsor_social->capitol_phone,
                    'district_phone' => $billRecordSponsor->bill_record_sponsor_social->district_phone,
                    'email' => $billRecordSponsor->bill_record_sponsor_social->email,
                    'webmail' => $billRecordSponsor->bill_record_sponsor_social->webmail,
                    'biography' => $billRecordSponsor->bill_record_sponsor_social->biography,
                    'image' => $billRecordSponsor->bill_record_sponsor_social->image,
                    'ballotpedia' => $billRecordSponsor->bill_record_sponsor_social->ballotpedia,
                    'votesmart' => $billRecordSponsor->bill_record_sponsor_social->votesmart,
                ],
                'capitol_address' => [
                    'address1' => $billRecordSponsor->bill_record_sponsor_capitol_address->address1,
                    'address2' => $billRecordSponsor->bill_record_sponsor_capitol_address->address2,
                    'city' => $billRecordSponsor->bill_record_sponsor_capitol_address->city,
                    'state' => $billRecordSponsor->bill_record_sponsor_capitol_address->state,
                    'zip' => $billRecordSponsor->bill_record_sponsor_capitol_address->zip,
                ],
                'links' => array_reduce(
                    $billRecordSponsor->bill_record_sponsor_links,
                    static function (array $acc, BillRecordSponsorLink $billRecordSponsorLink) {
                        $acc[$billRecordSponsorLink->bill_record_sponsor_link_type->value] = [
                            'bluesky' => $billRecordSponsorLink->bluesky,
                            'facebook' => $billRecordSponsorLink->facebook,
                            'instagram' => $billRecordSponsorLink->instagram,
                            'linkedin' => $billRecordSponsorLink->linkedin,
                            'tiktok' => $billRecordSponsorLink->tiktok,
                            'twitter' => $billRecordSponsorLink->twitter,
                            'website' => $billRecordSponsorLink->website,
                            'youtube' => $billRecordSponsorLink->youtube,
                        ];
                        return $acc;
                    }, 
                    [],
                ),
            ],
        ], $data->bill_record_sponsors),
        'sasts' => array_map(fn(BillRecordSast $billRecordSast) => [
            'type_id' => $billRecordSast->type_id,
            'type' => $billRecordSast->type,
            'sast_bill_number' => $billRecordSast->sast_bill_number,
            'sast_bill_id' => $billRecordSast->sast_bill_id,
        ], $data->bill_record_sasts),
        'subjects' => array_map(fn(BillRecordSubject $billRecordSubject) => [
            'subject_id' => $billRecordSubject->subject_id,
            'subject_name' => $billRecordSubject->subject_name,
        ], $data->bill_record_subjects),
        'texts' => array_map(fn(BillRecordText $billRecordText) => [
            'doc_id' => $billRecordText->doc_id,
            'date' => $billRecordText->date?->toIso8601String(),
            'type' => $billRecordText->type,
            'type_id' => $billRecordText->type_id,
            'mime' => $billRecordText->mime,
            'mime_id' => $billRecordText->mime_id,
            'url' => $billRecordText->url,
            'state_link' => $billRecordText->state_link,
            'text_size' => $billRecordText->text_size,
            'text_hash' => $billRecordText->text_hash,
        ], $data->bill_record_texts),
        'votes' => array_map(fn(BillRecordVote $billRecordVote) => [
            'roll_call_id' => $billRecordVote->roll_call_id,
            'date' => $billRecordVote->date?->toIso8601String(),
            'desc' => $billRecordVote->desc,
            'yea' => $billRecordVote->yea,
            'nay' => $billRecordVote->nay,
            'nv' => $billRecordVote->nv,
            'absent' => $billRecordVote->absent,
            'total' => $billRecordVote->total,
            'passed' => $billRecordVote->passed,
            'chamber' => $billRecordVote->chamber,
            'chamber_id' => $billRecordVote->chamber_id,
            'url' => $billRecordVote->url,
            'state_link' => $billRecordVote->state_link,
        ], $data->bill_record_votes),
        'amendments' => array_map(fn(BillRecordAmendment $billRecordAmendment) => [
            'amendment_id' => $billRecordAmendment->amendment_id,
            'adopted' => $billRecordAmendment->adopted,
            'chamber' => $billRecordAmendment->chamber,
            'chamber_id' => $billRecordAmendment->chamber_id,
            'date' => $billRecordAmendment->date?->toIso8601String(),
            'title' => $billRecordAmendment->title,
            'description' => $billRecordAmendment->description,
            'mime' => $billRecordAmendment->mime,
            'mime_id' => $billRecordAmendment->mime_id,
            'url' => $billRecordAmendment->url,
            'state_link' => $billRecordAmendment->state_link,
            'amendment_size' => $billRecordAmendment->amendment_size,
            'amendment_hash' => $billRecordAmendment->amendment_hash,
        ], $data->bill_record_amendments),
        'supplements' => array_map(fn(BillRecordSupplement $billRecordSupplement) => [
            'supplement_id' => $billRecordSupplement->supplement_id,
            'date' => $billRecordSupplement->date?->toIso8601String(),
            'type' => $billRecordSupplement->type,
            'type_id' => $billRecordSupplement->type_id,
            'title' => $billRecordSupplement->title,
            'description' => $billRecordSupplement->description,
            'mime' => $billRecordSupplement->mime,
            'mime_id' => $billRecordSupplement->mime_id,
            'url' => $billRecordSupplement->url,
            'state_link' => $billRecordSupplement->state_link,
            'supplement_size' => $billRecordSupplement->supplement_size,
            'supplement_hash' => $billRecordSupplement->supplement_hash,
        ], $data->bill_record_supplements),
        'calendar' => array_map(fn(BillRecordCalendar $billRecordCalendar) => [
            'type_id' => $billRecordCalendar->type_id,
            'type' => $billRecordCalendar->type,
            'date' => $billRecordCalendar->date?->toIso8601String(),
            'time' => $billRecordCalendar->time,
            'location' => $billRecordCalendar->location,
            'description' => $billRecordCalendar->description,
        ], $data->bill_record_calendars),
    ],
]);
