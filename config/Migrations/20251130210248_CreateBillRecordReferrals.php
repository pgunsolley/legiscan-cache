<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordReferrals extends BaseMigration
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
            ->table('bill_record_referrals')
            ->addColumn('bill_record_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('committee_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('chamber', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('chamber_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
