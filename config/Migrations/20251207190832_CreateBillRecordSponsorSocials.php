<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBillRecordSponsorSocials extends BaseMigration
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
            ->table('bill_record_sponsor_socials')
            ->addColumn('bill_record_sponsor_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('capitol_phone', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('district_phone', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('webmail', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('biography', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('ballotpedia', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('votesmart', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();
    }
}
