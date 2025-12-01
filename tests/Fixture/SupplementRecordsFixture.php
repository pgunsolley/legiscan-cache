<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SupplementRecordsFixture
 */
class SupplementRecordsFixture extends TestFixture
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
                'supplement_id' => 1,
                'bill_id' => 1,
                'date' => '2025-12-01',
                'type_id' => 1,
                'type' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'mime' => 'Lorem ipsum dolor sit amet',
                'mime_id' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'state_link' => 'Lorem ipsum dolor sit amet',
                'supplement_size' => 1,
                'supplement_hash' => 'Lorem ipsum dolor sit amet',
                'doc' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'alt_supplement' => 1,
                'alt_mime' => 'Lorem ipsum dolor sit amet',
                'alt_mime_id' => 1,
                'alt_state_link' => 'Lorem ipsum dolor sit amet',
                'alt_supplement_size' => 1,
                'alt_supplement_hash' => 'Lorem ipsum dolor sit amet',
                'alt_doc' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-12-01 01:39:50',
                'modified' => '2025-12-01 01:39:50',
            ],
        ];
        parent::init();
    }
}
