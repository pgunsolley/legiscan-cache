<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordSubjectsFixture
 */
class BillRecordSubjectsFixture extends TestFixture
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
                'subject_id' => 1,
                'subject_name' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:06',
                'modified' => '2025-12-01 01:39:06',
            ],
        ];
        parent::init();
    }
}
