<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordCalendars extends BaseMigration
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
            ->table('bill_record_calendars')
            ->addColumn('bill_record_id', 'integer', [
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
            ->addColumn('date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('time', 'time', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
