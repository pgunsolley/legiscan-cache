<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateBillRecords extends BaseMigration
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
            ->table('bill_records')
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('change_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('session_id', 'integer', [
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
            ->addColumn('completed', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('status_date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 2,
            ])
            ->addColumn('state_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('bill_number', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('bill_type', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('bill_type_id', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('body', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('body_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('current_body', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('current_body_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('pending_committee_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addColumn('last_sync', 'date', [
                'default' => null,
                'null' => false,
            ])
            ->addIndex('bill_id', [
                'unique' => true,
            ])
            ->addForeignKey('bill_id', 'master_list_records', 'bill_id', [
                'update' => 'NO_ACTION',
                'delete' => 'CASCADE',
            ])
            ->create();
    }
}
