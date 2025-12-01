<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordReferralsFixture
 */
class BillRecordReferralsFixture extends TestFixture
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
                'date' => '2025-12-01',
                'committee_id' => 1,
                'chamber' => 'Lorem ipsum dolor sit amet',
                'chamber_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:38:47',
                'modified' => '2025-12-01 01:38:47',
            ],
        ];
        parent::init();
    }
}
