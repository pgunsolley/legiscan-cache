<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordAmendmentsFixture
 */
class BillRecordAmendmentsFixture extends TestFixture
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
                'amendment_id' => 1,
                'adopted' => 1,
                'chamber' => 'Lorem ipsum dolor sit amet',
                'chamber_id' => 1,
                'date' => '2025-12-01',
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'mime' => 'Lorem ipsum dolor sit amet',
                'mime_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'amendment_size' => 1,
                'amendment_hash' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:18',
                'modified' => '2025-12-01 01:39:18',
            ],
        ];
        parent::init();
    }
}
