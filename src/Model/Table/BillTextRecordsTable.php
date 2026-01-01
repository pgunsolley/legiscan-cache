<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillTextRecords Model
 *
 * @method \App\Model\Entity\BillTextRecord newEmptyEntity()
 * @method \App\Model\Entity\BillTextRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillTextRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillTextRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillTextRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillTextRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillTextRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillTextRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillTextRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillTextRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillTextRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillTextRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillTextRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillTextRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillTextRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillTextRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillTextRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillTextRecordsTable extends Table
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

        $this->setTable('bill_text_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('BillRecordTexts', [
            'foreignKey' => 'doc_id',
            'bindingKey' => 'doc_id',
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
            ->nonNegativeInteger('doc_id')
            ->allowEmptyString('doc_id');

        $validator
            ->nonNegativeInteger('bill_id')
            ->allowEmptyString('bill_id');

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
            ->nonNegativeInteger('text_size')
            ->allowEmptyString('text_size');

        $validator
            ->scalar('text_hash')
            ->maxLength('text_hash', 255)
            ->allowEmptyString('text_hash');

        $validator
            ->scalar('doc')
            ->maxLength('doc', 16777215)
            ->allowEmptyString('doc');

        $validator
            ->nonNegativeInteger('alt_bill_text')
            ->allowEmptyString('alt_bill_text');

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
            ->nonNegativeInteger('alt_text_size')
            ->allowEmptyString('alt_text_size');

        $validator
            ->scalar('alt_doc')
            ->maxLength('alt_doc', 16777215)
            ->allowEmptyString('alt_doc');

        $validator
            ->date('last_sync')
            ->notEmptyDate('last_sync');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['doc_id', 'bill_id']));
        return $rules;
    }
}
