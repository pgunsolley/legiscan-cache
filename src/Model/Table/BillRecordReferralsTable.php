<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordReferrals Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordReferral newEmptyEntity()
 * @method \App\Model\Entity\BillRecordReferral newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordReferral> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordReferral get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordReferral findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordReferral patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordReferral> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordReferral|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordReferral saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordReferral>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordReferral>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordReferral>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordReferral> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordReferral>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordReferral>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordReferral>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordReferral> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordReferralsTable extends Table
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

        $this->setTable('bill_record_referrals');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->date('date')
            ->allowEmptyDate('date');

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
        $rules->add($rules->isUnique(['bill_record_id', 'commitee_id', 'chamber_id', 'date', 'name']));
        return $rules;
    }
}
