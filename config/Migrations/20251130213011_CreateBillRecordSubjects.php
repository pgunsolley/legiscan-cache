<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordSubjects extends BaseMigration
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
            ->table('bill_record_subjects')
            ->addColumn('bill_record_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('subject_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('subject_name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
