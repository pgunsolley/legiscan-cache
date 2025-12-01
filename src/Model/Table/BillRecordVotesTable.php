<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordVotes Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordVote newEmptyEntity()
 * @method \App\Model\Entity\BillRecordVote newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordVote> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordVote get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordVote findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordVote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordVote> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordVote|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordVote saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordVote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordVote>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordVote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordVote> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordVote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordVote>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordVote>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordVote> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordVotesTable extends Table
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

        $this->setTable('bill_record_votes');
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
            ->nonNegativeInteger('roll_call_id')
            ->allowEmptyString('roll_call_id');

        $validator
            ->date('date')
            ->allowEmptyDate('date');

        $validator
            ->scalar('desc')
            ->maxLength('desc', 255)
            ->allowEmptyString('desc');

        $validator
            ->nonNegativeInteger('yea')
            ->allowEmptyString('yea');

        $validator
            ->nonNegativeInteger('nay')
            ->allowEmptyString('nay');

        $validator
            ->nonNegativeInteger('nv')
            ->allowEmptyString('nv');

        $validator
            ->nonNegativeInteger('absent')
            ->allowEmptyString('absent');

        $validator
            ->nonNegativeInteger('total')
            ->allowEmptyString('total');

        $validator
            ->nonNegativeInteger('passed')
            ->allowEmptyString('passed');

        $validator
            ->scalar('chamber')
            ->maxLength('chamber', 255)
            ->allowEmptyString('chamber');

        $validator
            ->nonNegativeInteger('chamber_id')
            ->allowEmptyString('chamber_id');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->scalar('state_link')
            ->maxLength('state_link', 255)
            ->allowEmptyString('state_link');

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
