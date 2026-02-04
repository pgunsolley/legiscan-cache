<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordAmendments Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordAmendment newEmptyEntity()
 * @method \App\Model\Entity\BillRecordAmendment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordAmendment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordAmendment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordAmendment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordAmendment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordAmendment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordAmendment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordAmendment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordAmendment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordAmendment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordAmendment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordAmendment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordAmendment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordAmendment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordAmendment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordAmendment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordAmendmentsTable extends Table
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

        $this->setTable('bill_record_amendments');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('BillRecords', [
            'foreignKey' => 'bill_record_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('AmendmentRecords', [
            'foreignKey' => 'amendment_id',
            'bindingKey' => 'amendment_id',
        ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');
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
            ->nonNegativeInteger('amendment_id')
            ->allowEmptyString('amendment_id');

        $validator
            ->nonNegativeInteger('adopted')
            ->allowEmptyString('adopted');

        $validator
            ->scalar('chamber')
            ->maxLength('chamber', 255)
            ->allowEmptyString('chamber');

        $validator
            ->nonNegativeInteger('chamber_id')
            ->allowEmptyString('chamber_id');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

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
            ->integer('mime_id')
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
            ->nonNegativeInteger('amendment_size')
            ->allowEmptyString('amendment_size');

        $validator
            ->scalar('amendment_hash')
            ->maxLength('amendment_hash', 255)
            ->allowEmptyString('amendment_hash');

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
        $rules->add($rules->isUnique(['bill_record_id', 'amendment_id']));
        return $rules;
    }

    public function findByBillRecordId(SelectQuery $query, int $billRecordId): SelectQuery
    {
        return $query->where(['bill_record_id' => $billRecordId]);
    }
}
