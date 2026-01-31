<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSponsors Model
 *
 * @property \App\Model\Table\BillRecordsTable&\Cake\ORM\Association\BelongsTo $BillRecords
 *
 * @method \App\Model\Entity\BillRecordSponsor newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSponsor newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsor> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsor get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSponsor findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsor> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsor|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsor saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsor>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsor> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsor>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsor>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsor> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSponsorsTable extends Table
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

        $this->setTable('bill_record_sponsors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');

        $this->belongsTo('BillRecords', [
            'foreignKey' => 'bill_record_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('BillRecordSponsorCapitolAddresses', [
            'foreignKey' => 'bill_record_sponsor_id',
        ]);
        $this->hasOne('BillRecordSponsorSocials', [
            'foreignKey' => 'bill_record_sponsor_id',
        ]);
        $this->hasMany('BillRecordSponsorLinks', [
            'foreignKey' => 'bill_record_sponsor_id',
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
            ->nonNegativeInteger('people_id')
            ->allowEmptyString('people_id');

        $validator
            ->scalar('person_hash')
            ->maxLength('person_hash', 255)
            ->allowEmptyString('person_hash');

        $validator
            ->scalar('party_id')
            ->maxLength('party_id', 255)
            ->allowEmptyString('party_id');

        $validator
            ->nonNegativeInteger('state_id')
            ->allowEmptyString('state_id');

        $validator
            ->scalar('party')
            ->maxLength('party', 255)
            ->requirePresence('party', 'create')
            ->notEmptyString('party');

        $validator
            ->nonNegativeInteger('role_id')
            ->allowEmptyString('role_id');

        $validator
            ->scalar('role')
            ->maxLength('role', 255)
            ->allowEmptyString('role');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->allowEmptyString('first_name');

        $validator
            ->scalar('middle_name')
            ->maxLength('middle_name', 255)
            ->allowEmptyString('middle_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->allowEmptyString('last_name');

        $validator
            ->scalar('suffix')
            ->maxLength('suffix', 255)
            ->allowEmptyString('suffix');

        $validator
            ->scalar('nickname')
            ->maxLength('nickname', 255)
            ->allowEmptyString('nickname');

        $validator
            ->scalar('district')
            ->maxLength('district', 255)
            ->allowEmptyString('district');

        $validator
            ->nonNegativeInteger('ftm_eid')
            ->allowEmptyString('ftm_eid');

        $validator
            ->nonNegativeInteger('votesmart_id')
            ->allowEmptyString('votesmart_id');

        $validator
            ->scalar('opensecrets_id')
            ->maxLength('opensecrets_id', 255)
            ->allowEmptyString('opensecrets_id');

        $validator
            ->nonNegativeInteger('knowwho_pid')
            ->allowEmptyString('knowwho_pid');

        $validator
            ->scalar('ballotpedia')
            ->maxLength('ballotpedia', 255)
            ->allowEmptyString('ballotpedia');

        $validator
            ->scalar('bioguide_id')
            ->maxLength('bioguide_id', 255)
            ->allowEmptyString('bioguide_id');

        $validator
            ->nonNegativeInteger('sponsor_type_id')
            ->allowEmptyString('sponsor_type_id');

        $validator
            ->nonNegativeInteger('sponsor_order')
            ->allowEmptyString('sponsor_order');

        $validator
            ->nonNegativeInteger('committee_sponsor')
            ->allowEmptyString('committee_sponsor');

        $validator
            ->nonNegativeInteger('committee_id')
            ->allowEmptyString('committee_id');

        $validator
            ->nonNegativeInteger('state_federal')
            ->allowEmptyString('state_federal');

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
        $rules->add($rules->isUnique(['bill_record_id', 'state_id', 'party_id', 'first_name', 'middle_name', 'last_name']));
        return $rules;
    }
}
