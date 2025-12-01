<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSubjects Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordSubject newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSubject newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSubject> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSubject get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSubject findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSubject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSubject> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSubject|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSubject saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSubject>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSubject>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSubject>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSubject> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSubject>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSubject>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSubject>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSubject> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSubjectsTable extends Table
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

        $this->setTable('bill_record_subjects');
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
            ->nonNegativeInteger('subject_id')
            ->allowEmptyString('subject_id');

        $validator
            ->scalar('subject_name')
            ->maxLength('subject_name', 255)
            ->allowEmptyString('subject_name');

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
