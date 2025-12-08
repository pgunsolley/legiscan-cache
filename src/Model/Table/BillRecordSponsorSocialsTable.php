<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSponsorSocials Model
 *
 * @property \App\Model\Table\BillRecordSponsorsTable&\Cake\ORM\Association\BelongsTo $BillRecordSponsors
 *
 * @method \App\Model\Entity\BillRecordSponsorSocial newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSponsorSocial newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorSocial> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorSocial get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSponsorSocial findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorSocial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorSocial> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorSocial|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorSocial saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorSocial>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorSocial> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorSocial>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorSocial>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorSocial> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSponsorSocialsTable extends Table
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

        $this->setTable('bill_record_sponsor_socials');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->scalar('capitol_phone')
            ->maxLength('capitol_phone', 255)
            ->allowEmptyString('capitol_phone');

        $validator
            ->scalar('district_phone')
            ->maxLength('district_phone', 255)
            ->allowEmptyString('district_phone');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('webmail')
            ->maxLength('webmail', 255)
            ->allowEmptyString('webmail');

        $validator
            ->scalar('biography')
            ->maxLength('biography', 255)
            ->allowEmptyString('biography');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        $validator
            ->scalar('ballotpedia')
            ->maxLength('ballotpedia', 255)
            ->allowEmptyString('ballotpedia');

        $validator
            ->scalar('votesmart')
            ->maxLength('votesmart', 255)
            ->allowEmptyString('votesmart');

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
        $rules->add($rules->isUnique(['bill_record_sponsor_id', 'capitol_phone', 'district_phone', 'email', 'webmail', 'biography', 'image', 'ballotpedia', 'votesmart']));
        return $rules;
    }
}
