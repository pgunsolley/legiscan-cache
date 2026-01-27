<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Utility\StateAbbreviation;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SessionListRecords Model
 *
 * @method \App\Model\Entity\SessionListRecord newEmptyEntity()
 * @method \App\Model\Entity\SessionListRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SessionListRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SessionListRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SessionListRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SessionListRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SessionListRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SessionListRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SessionListRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SessionListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SessionListRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SessionListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SessionListRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SessionListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SessionListRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SessionListRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SessionListRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessionListRecordsTable extends Table
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

        $this->setTable('session_list_records');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MasterListRecords', [
            'foreignKey' => 'session_id',
            'bindingKey' => 'session_id',
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
            ->nonNegativeInteger('session_id')
            ->allowEmptyString('session_id');

        $validator
            ->nonNegativeInteger('state_id')
            ->allowEmptyString('state_id');

        $validator
            ->scalar('state_abbr')
            ->maxLength('state_abbr', 2)
            ->allowEmptyString('state_abbr');

        $validator
            ->integer('year_start')
            ->allowEmptyDate('year_start');

        $validator
            ->integer('year_end')
            ->allowEmptyDate('year_end');

        $validator
            ->integer('prefile')
            ->allowEmptyString('prefile');

        $validator
            ->integer('sine_die')
            ->allowEmptyString('sine_die');

        $validator
            ->integer('prior')
            ->allowEmptyString('prior');

        $validator
            ->integer('special')
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

        $validator
            ->scalar('dataset_hash')
            ->maxLength('dataset_hash', 255)
            ->allowEmptyString('dataset_hash');

        $validator
            ->scalar('session_hash')
            ->maxLength('session_hash', 255)
            ->allowEmptyString('session_hash');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->date('last_sync');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['session_id']));
        return $rules;
    }

    public function findByState(SelectQuery $query, StateAbbreviation $stateAbbreviation): SelectQuery
    {
        return $query->where(['state_abbr' => $stateAbbreviation->value]);
    }

    public function countByState(StateAbbreviation $stateAbbreviation): int
    {
        return $this->find('byState', $stateAbbreviation)->count();
    }
}
