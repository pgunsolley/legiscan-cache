<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateSessionListRecords extends BaseMigration
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
            ->table('session_list_records')
            ->addColumn('session_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('state_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('state_abbr', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 2,
            ])
            ->addColumn('year_start', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('year_end', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('prefile', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('sine_die', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('prior', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('special', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('session_tag', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('session_title', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('session_name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('dataset_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('session_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
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
