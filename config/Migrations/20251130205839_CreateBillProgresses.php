<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateBillProgresses extends BaseMigration
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
            ->table('bill_progresses')
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('date', 'date', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('event', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
