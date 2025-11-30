<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateBillSessions extends BaseMigration
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
            ->table('bill_sessions')
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
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
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('sine_die', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('prior', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('special', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
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
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
