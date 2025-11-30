<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordVotes extends BaseMigration
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
            ->table('bill_record_votes')
            ->addColumn('bill_record_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('roll_call_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('desc', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('yea', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('nay', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('nv', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('absent', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('total', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('passed', 'integer', [
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
            ->addColumn('url', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('state_link', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
