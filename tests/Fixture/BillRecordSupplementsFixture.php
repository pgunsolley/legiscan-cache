<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordSupplementsFixture
 */
class BillRecordSupplementsFixture extends TestFixture
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
                'supplement_id' => 1,
                'date' => '2025-12-01',
                'type' => 'Lorem ipsum dolor sit amet',
                'type_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'mime' => 'Lorem ipsum dolor sit amet',
                'mime_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'supplement_size' => 1,
                'supplement_hash' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:24',
                'modified' => '2025-12-01 01:39:24',
            ],
        ];
        parent::init();
    }
}
