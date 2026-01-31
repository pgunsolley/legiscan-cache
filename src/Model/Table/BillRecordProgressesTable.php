<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordProgresses Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordProgress newEmptyEntity()
 * @method \App\Model\Entity\BillRecordProgress newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordProgress> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordProgress get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordProgress findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordProgress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordProgress> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordProgress|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordProgress saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordProgress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordProgress>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordProgress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordProgress> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordProgress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordProgress>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordProgress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordProgress> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordProgressesTable extends Table
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

        $this->setTable('bill_record_progresses');
        $this->setDisplayField('id');
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
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->nonNegativeInteger('event')
            ->allowEmptyString('event');

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
        return $rules;
    }
}
