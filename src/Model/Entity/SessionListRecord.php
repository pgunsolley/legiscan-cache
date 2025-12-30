<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SessionListRecord Entity
 *
 * @property int $id
 * @property int|null $session_id
 * @property int|null $state_id
 * @property string|null $state_abbr
 * @property int|null $year_start
 * @property int|null $year_end
 * @property int|null $prefile
 * @property int|null $sine_die
 * @property int|null $prior
 * @property int|null $special
 * @property string|null $session_tag
 * @property string|null $session_title
 * @property string|null $session_name
 * @property string|null $dataset_hash
 * @property string|null $session_hash
 * @property string|null $name
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \Cake\I18n\Date $last_sync
 * @property \App\Model\Entity\MasterListRecord[] $master_list_records
 */
class SessionListRecord extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'session_id' => true,
        'state_id' => true,
        'state_abbr' => true,
        'year_start' => true,
        'year_end' => true,
        'prefile' => true,
        'sine_die' => true,
        'prior' => true,
        'special' => true,
        'session_tag' => true,
        'session_title' => true,
        'session_name' => true,
        'dataset_hash' => true,
        'session_hash' => true,
        'name' => true,
        'created' => true,
        'modified' => true,
        'last_sync' => true,
    ];
}
