<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillSasts extends BaseMigration
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
            ->table('bill_sasts')
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('type_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('sast_bill_number', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('sast_bill_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
