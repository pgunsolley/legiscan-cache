<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SessionListRecordsFixture
 */
class SessionListRecordsFixture extends TestFixture
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
                'session_id' => 1,
                'state_id' => 1,
                'state_abbr' => 'Lo',
                'year_start' => '2025-12-01',
                'year_end' => '2025-12-01',
                'prefile' => 1,
                'sine_die' => 1,
                'prior' => 1,
                'special' => 1,
                'session_tag' => 'Lorem ipsum dolor sit amet',
                'session_title' => 'Lorem ipsum dolor sit amet',
                'session_name' => 'Lorem ipsum dolor sit amet',
                'dataset_hash' => 'Lorem ipsum dolor sit amet',
                'session_hash' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:27:32',
                'modified' => '2025-12-01 01:27:32',
            ],
        ];
        parent::init();
    }
}
