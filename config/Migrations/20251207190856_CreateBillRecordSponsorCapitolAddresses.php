<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordSponsorCapitolAddresses extends BaseMigration
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
            ->table('bill_record_sponsor_capitol_addresses')
            ->addColumn('bill_record_sponsor_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('address1', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('address2', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 2,
            ])
            ->addColumn('zip', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
