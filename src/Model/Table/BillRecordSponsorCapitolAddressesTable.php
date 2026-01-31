<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSponsorCapitolAddresses Model
 *
 * @property \App\Model\Table\BillRecordSponsorsTable&\Cake\ORM\Association\BelongsTo $BillRecordSponsors
 *
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorCapitolAddress> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorCapitolAddress> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorCapitolAddress saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorCapitolAddress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorCapitolAddress>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorCapitolAddress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorCapitolAddress> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorCapitolAddress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorCapitolAddress>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorCapitolAddress>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorCapitolAddress> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSponsorCapitolAddressesTable extends Table
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

        $this->setTable('bill_record_sponsor_capitol_addresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Pick');

        $this->belongsTo('BillRecordSponsors', [
            'foreignKey' => 'bill_record_sponsor_id',
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
            ->integer('bill_record_sponsor_id')
            ->notEmptyString('bill_record_sponsor_id');

        $validator
            ->scalar('address1')
            ->maxLength('address1', 255)
            ->allowEmptyString('address1');

        $validator
            ->scalar('address2')
            ->maxLength('address2', 255)
            ->allowEmptyString('address2');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 2)
            ->allowEmptyString('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 255)
            ->allowEmptyString('zip');

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
        $rules->add($rules->existsIn(['bill_record_sponsor_id'], 'BillRecordSponsors'), ['errorField' => 'bill_record_sponsor_id']);
        $rules->add($rules->isUnique(['bill_record_sponsor_id', 'address1', 'address2', 'city', 'state', 'zip']));
        return $rules;
    }
}
