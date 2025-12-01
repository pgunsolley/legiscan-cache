<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordSessionsFixture
 */
class BillRecordSessionsFixture extends TestFixture
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
                'session_id' => 1,
                'state_id' => 1,
                'year_start' => 1,
                'year_end' => 1,
                'prefile' => 1,
                'sine_die' => 1,
                'prior' => 1,
                'special' => 1,
                'session_tag' => 'Lorem ipsum dolor sit amet',
                'session_title' => 'Lorem ipsum dolor sit amet',
                'session_name' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:38:28',
                'modified' => '2025-12-01 01:38:28',
            ],
        ];
        parent::init();
    }
}
