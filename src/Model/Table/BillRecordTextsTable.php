<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordTexts Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordText newEmptyEntity()
 * @method \App\Model\Entity\BillRecordText newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordText> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordText get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordText findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordText patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordText> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordText|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordText saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordText>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordText>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordText>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordText> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordText>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordText>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordText>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordText> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordTextsTable extends Table
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

        $this->setTable('bill_record_texts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');

        $this->belongsTo('BillRecords', [
            'foreignKey' => 'bill_record_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('BillTextRecords', [
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
            ->integer('bill_record_id')
            ->notEmptyString('bill_record_id');

        $validator
            ->nonNegativeInteger('doc_id')
            ->allowEmptyString('doc_id');

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
            ->scalar('alt_text_hash')
            ->maxLength('alt_text_hash', 255)
            ->allowEmptyString('alt_text_hash');

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
        $rules->add($rules->isUnique(['bill_record_id', 'doc_id']));
        return $rules;
    }
}
