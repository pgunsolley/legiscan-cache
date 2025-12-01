<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSessions Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordSession newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSession newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSession> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSession get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSession findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSession patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSession> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSession|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSession saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSession>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSession> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSession>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSession>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSession> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSessionsTable extends Table
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

        $this->setTable('bill_record_sessions');
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
            ->nonNegativeInteger('session_id')
            ->allowEmptyString('session_id');

        $validator
            ->nonNegativeInteger('state_id')
            ->allowEmptyString('state_id');

        $validator
            ->integer('year_start')
            ->allowEmptyString('year_start');

        $validator
            ->integer('year_end')
            ->allowEmptyString('year_end');

        $validator
            ->nonNegativeInteger('prefile')
            ->allowEmptyString('prefile');

        $validator
            ->nonNegativeInteger('sine_die')
            ->allowEmptyString('sine_die');

        $validator
            ->nonNegativeInteger('prior')
            ->allowEmptyString('prior');

        $validator
            ->nonNegativeInteger('special')
            ->allowEmptyString('special');

        $validator
            ->scalar('session_tag')
            ->maxLength('session_tag', 255)
            ->allowEmptyString('session_tag');

        $validator
            ->scalar('session_title')
            ->maxLength('session_title', 255)
            ->allowEmptyString('session_title');

        $validator
            ->scalar('session_name')
            ->maxLength('session_name', 255)
            ->allowEmptyString('session_name');

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
