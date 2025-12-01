<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordsFixture
 */
class BillRecordsFixture extends TestFixture
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
                'bill_id' => 1,
                'change_hash' => 'Lorem ipsum dolor sit amet',
                'session_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'completed' => 1,
                'status' => 1,
                'status_date' => '2025-12-01',
                'state' => 'Lo',
                'state_id' => 1,
                'bill_number' => 'Lorem ipsum dolor sit amet',
                'bill_type' => 'Lorem ipsum dolor sit amet',
                'bill_type_id' => 'Lorem ipsum dolor sit amet',
                'body' => 'Lorem ipsum dolor sit amet',
                'body_id' => 1,
                'current_body' => 'Lorem ipsum dolor sit amet',
                'current_body_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'pending_committee_id' => 1,
                'created' => '2025-12-01 01:37:39',
                'modified' => '2025-12-01 01:37:39',
            ],
        ];
        parent::init();
    }
}
