<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MasterListRecordsFixture
 */
class MasterListRecordsFixture extends TestFixture
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
                'number' => 'Lorem ipsum dolor sit amet',
                'change_hash' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'status_date' => '2025-12-01',
                'status' => 1,
                'last_action_date' => '2025-12-01',
                'last_action' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:27:41',
                'modified' => '2025-12-01 01:27:41',
            ],
        ];
        parent::init();
    }
}
