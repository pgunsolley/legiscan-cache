<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordVotesFixture
 */
class BillRecordVotesFixture extends TestFixture
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
                'roll_call_id' => 1,
                'date' => '2025-12-01',
                'desc' => 'Lorem ipsum dolor sit amet',
                'yea' => 1,
                'nay' => 1,
                'nv' => 1,
                'absent' => 1,
                'total' => 1,
                'passed' => 1,
                'chamber' => 'Lorem ipsum dolor sit amet',
                'chamber_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:14',
                'modified' => '2025-12-01 01:39:14',
            ],
        ];
        parent::init();
    }
}
