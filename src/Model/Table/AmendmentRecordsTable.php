<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AmendmentRecords Model
 *
 * @method \App\Model\Entity\AmendmentRecord newEmptyEntity()
 * @method \App\Model\Entity\AmendmentRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AmendmentRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AmendmentRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AmendmentRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AmendmentRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AmendmentRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AmendmentRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AmendmentRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AmendmentRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AmendmentRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AmendmentRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AmendmentRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AmendmentRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AmendmentRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AmendmentRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AmendmentRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AmendmentRecordsTable extends Table
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

        $this->setTable('amendment_records');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('BillRecordAmendments', [
            'foreignKey' => 'amendment_id',
            'bindingKey' => 'amendment_id',
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
            ->nonNegativeInteger('amendment_id')
            ->allowEmptyString('amendment_id');

        $validator
            ->nonNegativeInteger('bill_id')
            ->allowEmptyString('bill_id');

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
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
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
            ->nonNegativeInteger('amendment_size')
            ->allowEmptyString('amendment_size');

        $validator
            ->scalar('amendment_hash')
            ->maxLength('amendment_hash', 255)
            ->allowEmptyString('amendment_hash');

        $validator
            ->scalar('doc')
            ->maxLength('doc', 16777215)
            ->allowEmptyString('doc');

        $validator
            ->nonNegativeInteger('alt_amendment')
            ->allowEmptyString('alt_amendment');

        $validator
            ->scalar('alt_mime')
            ->maxLength('alt_mime', 255)
            ->allowEmptyString('alt_mime');

        $validator
            ->nonNegativeInteger('alt_mime_id')
            ->allowEmptyString('alt_mime_id');

        $validator
            ->scalar('alt_state_link')
            ->maxLength('alt_state_link', 255)
            ->allowEmptyString('alt_state_link');

        $validator
            ->nonNegativeInteger('alt_amendment_size')
            ->allowEmptyString('alt_amendment_size');

        $validator
            ->scalar('alt_amendment_hash')
            ->maxLength('alt_amendment_hash', 255)
            ->allowEmptyString('alt_amendment_hash');

        $validator
            ->scalar('alt_doc')
            ->maxLength('alt_doc', 16777215)
            ->allowEmptyString('alt_doc');

        $validator
            ->date('last_sync');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['amendment_id', 'bill_id']));
        return $rules;
    }
}
