<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateAmendmentRecords extends BaseMigration
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
            ->table('amendment_records')
            ->addColumn('amendment_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('bill_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('adopted', 'integer', [
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
            ->addColumn('date', 'date', [
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
            ->addColumn('mime', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('mime_id', 'integer', [
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
            ->addColumn('amendment_size', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('amendment_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('doc', 'text', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::TEXT_MEDIUM,
            ])
            ->addColumn('alt_amendment', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('alt_mime', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('alt_mime_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('alt_state_link', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('alt_amendment_size', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('alt_amendment_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('alt_doc', 'text', [
                'default' => null,
                'null' => true,
                'limit' => MysqlAdapter::TEXT_MEDIUM,
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
