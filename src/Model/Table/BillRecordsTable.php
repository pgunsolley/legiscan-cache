<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecords Model
 *
 * @property \App\Model\Table\BillRecordAmendmentsTable&\Cake\ORM\Association\HasMany $BillRecordAmendments
 * @property \App\Model\Table\BillRecordCalendarsTable&\Cake\ORM\Association\HasMany $BillRecordCalendars
 * @property \App\Model\Table\BillRecordCommitteesTable&\Cake\ORM\Association\HasMany $BillRecordCommittees
 * @property \App\Model\Table\BillRecordHistoriesTable&\Cake\ORM\Association\HasMany $BillRecordHistories
 * @property \App\Model\Table\BillRecordProgressesTable&\Cake\ORM\Association\HasMany $BillRecordProgresses
 * @property \App\Model\Table\BillRecordReferralsTable&\Cake\ORM\Association\HasMany $BillRecordReferrals
 * @property \App\Model\Table\BillRecordSastsTable&\Cake\ORM\Association\HasMany $BillRecordSasts
 * @property \App\Model\Table\BillRecordSessionsTable&\Cake\ORM\Association\HasMany $BillRecordSessions
 * @property \App\Model\Table\BillRecordSponsorsTable&\Cake\ORM\Association\HasMany $BillRecordSponsors
 * @property \App\Model\Table\BillRecordSubjectsTable&\Cake\ORM\Association\HasMany $BillRecordSubjects
 * @property \App\Model\Table\BillRecordSupplementsTable&\Cake\ORM\Association\HasMany $BillRecordSupplements
 * @property \App\Model\Table\BillRecordTextsTable&\Cake\ORM\Association\HasMany $BillRecordTexts
 * @property \App\Model\Table\BillRecordVotesTable&\Cake\ORM\Association\HasMany $BillRecordVotes
 *
 * @method \App\Model\Entity\BillRecord newEmptyEntity()
 * @method \App\Model\Entity\BillRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('bill_records');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('BillRecordAmendments', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordCalendars', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordCommittees', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordHistories', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordProgresses', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordReferrals', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordSasts', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasOne('BillRecordSessions', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordSponsors', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordSubjects', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordSupplements', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordTexts', [
            'foreignKey' => 'bill_record_id',
        ]);
        $this->hasMany('BillRecordVotes', [
            'foreignKey' => 'bill_record_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('bill_id')
            ->allowEmptyString('bill_id');

        $validator
            ->scalar('change_hash')
            ->maxLength('change_hash', 255)
            ->allowEmptyString('change_hash');

        $validator
            ->nonNegativeInteger('session_id')
            ->allowEmptyString('session_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('state_link')
            ->maxLength('state_link', 255)
            ->allowEmptyString('state_link');

        $validator
            ->nonNegativeInteger('completed')
            ->allowEmptyString('completed');

        $validator
            ->nonNegativeInteger('status')
            ->allowEmptyString('status');

        $validator
            ->date('status_date')
            ->allowEmptyDate('status_date');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->allowEmptyString('state');

        $validator
            ->nonNegativeInteger('state_id')
            ->allowEmptyString('state_id');

        $validator
            ->scalar('bill_number')
            ->maxLength('bill_number', 255)
            ->allowEmptyString('bill_number');

        $validator
            ->scalar('bill_type')
            ->maxLength('bill_type', 255)
            ->allowEmptyString('bill_type');

        $validator
            ->scalar('bill_type_id')
            ->maxLength('bill_type_id', 255)
            ->allowEmptyString('bill_type_id');

        $validator
            ->scalar('body')
            ->maxLength('body', 255)
            ->allowEmptyString('body');

        $validator
            ->nonNegativeInteger('body_id')
            ->allowEmptyString('body_id');

        $validator
            ->scalar('current_body')
            ->maxLength('current_body', 255)
            ->allowEmptyString('current_body');

        $validator
            ->nonNegativeInteger('current_body_id')
            ->allowEmptyString('current_body_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->nonNegativeInteger('pending_committee_id')
            ->allowEmptyString('pending_committee_id');

        $validator
            ->date('last_sync')
            ->requirePresence('last_sync', true)
            ->notEmptyDate('last_sync');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['bill_id']));
        return $rules;
    }

    public function findByBillId(SelectQuery $query, int $billId): SelectQuery
    {
        return $query->where(['bill_id' => $billId]);
    }
}
