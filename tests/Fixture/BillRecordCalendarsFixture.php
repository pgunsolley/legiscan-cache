<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordCalendarsFixture
 */
class BillRecordCalendarsFixture extends TestFixture
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
                'date' => '2025-12-01',
                'time' => '01:39:29',
                'location' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:29',
                'modified' => '2025-12-01 01:39:29',
            ],
        ];
        parent::init();
    }
}
