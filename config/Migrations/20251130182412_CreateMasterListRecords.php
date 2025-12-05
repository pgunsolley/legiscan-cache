<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateMasterListRecords extends BaseMigration
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
            ->table('master_list_records')
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('change_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('status_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('last_action_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('last_action', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addColumn('last_sync', 'date', [
                'default' => null,
                'null' => false,
            ])
            ->create();
    }
}
