<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordProgressesFixture
 */
class BillRecordProgressesFixture extends TestFixture
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
                'event' => 1,
                'created' => '2025-12-01 01:38:34',
                'modified' => '2025-12-01 01:38:34',
            ],
        ];
        parent::init();
    }
}
