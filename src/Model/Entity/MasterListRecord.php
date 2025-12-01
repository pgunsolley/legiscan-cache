<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterListRecord Entity
 *
 * @property int $id
 * @property int|null $bill_id
 * @property string|null $number
 * @property string|null $change_hash
 * @property string|null $url
 * @property \Cake\I18n\Date|null $status_date
 * @property int|null $status
 * @property \Cake\I18n\Date|null $last_action_date
 * @property string|null $last_action
 * @property string|null $title
 * @property string|null $description
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class MasterListRecord extends Entity
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
        'bill_id' => true,
        'number' => true,
        'change_hash' => true,
        'url' => true,
        'status_date' => true,
        'status' => true,
        'last_action_date' => true,
        'last_action' => true,
        'title' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
    ];
}
