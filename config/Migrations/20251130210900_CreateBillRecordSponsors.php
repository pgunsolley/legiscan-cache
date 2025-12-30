<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Adapter\MysqlAdapter;

class CreateBillRecordSponsors extends BaseMigration
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
            ->table('bill_record_sponsors')
            ->addColumn('bill_record_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('people_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('person_hash', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('party_id', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('state_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
                'limit' => MysqlAdapter::INT_TINY,
            ])
            ->addColumn('party', 'string', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('role_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('role', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('middle_name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('suffix', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('nickname', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('district', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('ftm_eid', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('votesmart_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('opensecrets_id', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('knowwho_pid', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('ballotpedia', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('bioguide_id', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('sponsor_type_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('sponsor_order', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('committee_sponsor', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('committee_id', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('state_federal', 'integer', [
                'default' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addForeignKey('bill_record_id', 'bill_records', 'id', [
                'update' => 'NO_ACTION',
                'delete' => 'CASCADE',
            ])
            ->create();
    }
}
