<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordCommittees Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordCommittee newEmptyEntity()
 * @method \App\Model\Entity\BillRecordCommittee newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordCommittee> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordCommittee get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordCommittee findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordCommittee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordCommittee> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordCommittee|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordCommittee saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordCommittee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordCommittee>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordCommittee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordCommittee> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordCommittee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordCommittee>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordCommittee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordCommittee> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordCommitteesTable extends Table
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

        $this->setTable('bill_record_committees');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');

        $this->belongsTo('BillRecords', [
            'foreignKey' => 'bill_record_id',
            'joinType' => 'INNER',
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
            ->integer('bill_record_id')
            ->notEmptyString('bill_record_id');

        $validator
            ->nonNegativeInteger('committee_id')
            ->allowEmptyString('committee_id');

        $validator
            ->scalar('chamber')
            ->maxLength('chamber', 255)
            ->allowEmptyString('chamber');

        $validator
            ->nonNegativeInteger('chamber_id')
            ->allowEmptyString('chamber_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['bill_record_id'], 'BillRecords'), ['errorField' => 'bill_record_id']);
        $rules->add($rules->isUnique(['bill_record_id', 'committee_id', 'chamber_id', 'name']));
        return $rules;
    }
}
