<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordSponsorsFixture
 */
class BillRecordSponsorsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'bill_record_id' => 1,
                'people_id' => 1,
                'person_hash' => 'Lorem ipsum dolor sit amet',
                'party_id' => 'Lorem ipsum dolor sit amet',
                'state_id' => 1,
                'party' => 'Lorem ipsum dolor sit amet',
                'role_id' => 1,
                'role' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'middle_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'suffix' => 'Lorem ipsum dolor sit amet',
                'nickname' => 'Lorem ipsum dolor sit amet',
                'district' => 'Lorem ipsum dolor sit amet',
                'ftm_eid' => 1,
                'votesmart_id' => 1,
                'opensecrets_id' => 'Lorem ipsum dolor sit amet',
                'knowwho_pid' => 1,
                'ballotpedia' => 'Lorem ipsum dolor sit amet',
                'bioguide_id' => 'Lorem ipsum dolor sit amet',
                'sponsor_type_id' => 1,
                'sponsor_order' => 1,
                'committee_sponsor' => 1,
                'committee_id' => 1,
                'state_federal' => 1,
                'created' => '2025-12-01 01:38:57',
                'modified' => '2025-12-01 01:38:57',
            ],
        ];
        parent::init();
    }
}
