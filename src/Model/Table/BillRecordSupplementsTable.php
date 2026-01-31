<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSupplements Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordSupplement newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSupplement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSupplement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSupplement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSupplement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSupplement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSupplement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSupplement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSupplement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSupplement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSupplement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSupplement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSupplement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSupplement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSupplement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSupplement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSupplement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSupplementsTable extends Table
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

        $this->setTable('bill_record_supplements');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');

        $this->belongsTo('BillRecords', [
            'foreignKey' => 'bill_record_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('SupplementRecords', [
            'foreignKey' => 'supplement_id',
            'bindingKey' => 'supplement_id',
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
            ->nonNegativeInteger('supplement_id')
            ->allowEmptyString('supplement_id');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmptyString('type');

        $validator
            ->nonNegativeInteger('type_id')
            ->allowEmptyString('type_id');

        $validator
            ->scalar('title')
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('mime')
            ->maxLength('mime', 255)
            ->allowEmptyString('mime');

        $validator
            ->nonNegativeInteger('mime_id')
            ->allowEmptyString('mime_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('state_link')
            ->maxLength('state_link', 255)
            ->allowEmptyString('state_link');

        $validator
            ->nonNegativeInteger('supplement_size')
            ->allowEmptyString('supplement_size');

        $validator
            ->scalar('supplement_hash')
            ->maxLength('supplement_hash', 255)
            ->allowEmptyString('supplement_hash');

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
        $rules->add($rules->isUnique(['bill_record_id', 'supplement_id', 'date']));
        return $rules;
    }
}
