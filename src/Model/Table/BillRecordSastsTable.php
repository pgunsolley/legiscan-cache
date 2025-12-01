<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSasts Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordSast newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSast newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSast> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSast get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSast findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSast patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSast> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSast|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSast saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSast>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSast>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSast>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSast> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSast>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSast>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSast>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSast> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSastsTable extends Table
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

        $this->setTable('bill_record_sasts');
        $this->setDisplayField('id');
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
            ->nonNegativeInteger('type_id')
            ->allowEmptyString('type_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->scalar('sast_bill_number')
            ->maxLength('sast_bill_number', 255)
            ->allowEmptyString('sast_bill_number');

        $validator
            ->nonNegativeInteger('sast_bill_id')
            ->allowEmptyString('sast_bill_id');

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
