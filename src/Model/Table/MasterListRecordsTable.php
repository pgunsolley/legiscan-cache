<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterListRecords Model
 *
 * @method \App\Model\Entity\MasterListRecord newEmptyEntity()
 * @method \App\Model\Entity\MasterListRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\MasterListRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterListRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\MasterListRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\MasterListRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\MasterListRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterListRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\MasterListRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\MasterListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MasterListRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MasterListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MasterListRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MasterListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MasterListRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MasterListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MasterListRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MasterListRecordsTable extends Table
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

        $this->setTable('master_list_records');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('SessionListRecords', [
            'foreignKey' => 'session_id',
            'bindingKey' => 'session_id',
        ]);
        $this->hasOne('BillRecords', [
            'foreignKey' => 'bill_id',
            'bindingKey' => 'bill_id', 
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
            ->integer('session_id');

        $validator
            ->nonNegativeInteger('bill_id')
            ->allowEmptyString('bill_id');

        $validator
            ->scalar('number')
            ->maxLength('number', 255)
            ->allowEmptyString('number');

        $validator
            ->scalar('change_hash')
            ->maxLength('change_hash', 255)
            ->allowEmptyString('change_hash');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->date('status_date')
            ->allowEmptyDate('status_date');

        $validator
            ->nonNegativeInteger('status')
            ->allowEmptyString('status');

        $validator
            ->date('last_action_date')
            ->allowEmptyDate('last_action_date');

        $validator
            ->scalar('last_action')
            ->maxLength('last_action', 255)
            ->allowEmptyString('last_action');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->date('last_sync');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['session_id', 'bill_id']));
        return $rules;
    }
}
