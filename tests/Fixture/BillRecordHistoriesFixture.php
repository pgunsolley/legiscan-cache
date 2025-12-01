<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordHistoriesFixture
 */
class BillRecordHistoriesFixture extends TestFixture
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
                'action' => 'Lorem ipsum dolor sit amet',
                'chamber' => 'Lorem ipsum dolor sit amet',
                'chamber_id' => 1,
                'importance' => 1,
                'created' => '2025-12-01 01:38:53',
                'modified' => '2025-12-01 01:38:53',
            ],
        ];
        parent::init();
    }
}
