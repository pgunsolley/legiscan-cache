<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Enum\BillRecordSponsorLinkType;
use Cake\Database\Type\EnumType;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BillRecordSponsorLinks Model
 *
 * @property \App\Model\Table\BillRecordSponsorsTable&\Cake\ORM\Association\BelongsTo $BillRecordSponsors
 *
 * @method \App\Model\Entity\BillRecordSponsorLink newEmptyEntity()
 * @method \App\Model\Entity\BillRecordSponsorLink newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorLink> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorLink get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BillRecordSponsorLink findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BillRecordSponsorLink> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorLink|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BillRecordSponsorLink saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorLink>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorLink> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorLink>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BillRecordSponsorLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BillRecordSponsorLink> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BillRecordSponsorLinksTable extends Table
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

        $this->getSchema()->setColumnType('bill_record_sponsor_link_type', EnumType::from(BillRecordSponsorLinkType::class));

        $this->setTable('bill_record_sponsor_links');
        $this->setDisplayField('bill_record_sponsor_link_type');
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
            ->enum('bill_record_sponsor_link_type', BillRecordSponsorLinkType::class)
            ->requirePresence('bill_record_sponsor_link_type', 'create')
            ->notEmptyString('bill_record_sponsor_link_type');

        $validator
            ->scalar('bluesky')
            ->maxLength('bluesky', 255)
            ->allowEmptyString('bluesky');

        $validator
            ->scalar('facebook')
            ->maxLength('facebook', 255)
            ->allowEmptyString('facebook');

        $validator
            ->scalar('instagram')
            ->maxLength('instagram', 255)
            ->allowEmptyString('instagram');

        $validator
            ->scalar('linkedin')
            ->maxLength('linkedin', 255)
            ->allowEmptyString('linkedin');

        $validator
            ->scalar('tiktok')
            ->maxLength('tiktok', 255)
            ->allowEmptyString('tiktok');

        $validator
            ->scalar('twitter')
            ->maxLength('twitter', 255)
            ->allowEmptyString('twitter');

        $validator
            ->scalar('website')
            ->maxLength('website', 255)
            ->allowEmptyString('website');

        $validator
            ->scalar('youtube')
            ->maxLength('youtube', 255)
            ->allowEmptyString('youtube');

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
        $rules->add($rules->isUnique(['bill_record_sponsor_id', 'bill_record_sponsor_link_type', 'bluesky', 'facebook', 'instagram', 'linkedin', 'tiktok', 'twitter', 'website', 'youtube']));
        return $rules;
    }
}
