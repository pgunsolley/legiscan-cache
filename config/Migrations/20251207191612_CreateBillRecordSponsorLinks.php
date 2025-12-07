<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordSponsorLinks extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $this
            ->table('bill_record_sponsor_links')
            ->addColumn('bill_record_sponsor_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('bill_record_sponsor_link_type', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('bluesky', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('facebook', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('instagram', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('linkedin', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('tiktok', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('twitter', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('website', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('youtube', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
