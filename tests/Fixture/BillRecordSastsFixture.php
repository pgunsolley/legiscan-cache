<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordSastsFixture
 */
class BillRecordSastsFixture extends TestFixture
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
                'type_id' => 1,
                'type' => 'Lorem ipsum dolor sit amet',
                'sast_bill_number' => 'Lorem ipsum dolor sit amet',
                'sast_bill_id' => 1,
                'created' => '2025-12-01 01:39:01',
                'modified' => '2025-12-01 01:39:01',
            ],
        ];
        parent::init();
    }
}
