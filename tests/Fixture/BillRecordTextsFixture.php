<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BillRecordTextsFixture
 */
class BillRecordTextsFixture extends TestFixture
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
                'doc_id' => 1,
                'date' => '2025-12-01',
                'type' => 'Lorem ipsum dolor sit amet',
                'type_id' => 1,
                'mime' => 'Lorem ipsum dolor sit amet',
                'mime_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'text_size' => 1,
                'text_hash' => 'Lorem ipsum dolor sit amet',
                'alt_bill_text' => 1,
                'alt_mime' => 'Lorem ipsum dolor sit amet',
                'alt_mime_id' => 1,
                'alt_state_link' => 'Lorem ipsum dolor sit amet',
                'alt_text_size' => 1,
                'alt_text_hash' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-12-01 01:39:10',
                'modified' => '2025-12-01 01:39:10',
            ],
        ];
        parent::init();
    }
}
