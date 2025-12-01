<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SupplementRecord Entity
 *
 * @property int $id
 * @property int|null $supplement_id
 * @property int|null $bill_id
 * @property \Cake\I18n\Date|null $date
 * @property int|null $type_id
 * @property string|null $type
 * @property string|null $title
 * @property string|null $description
 * @property string|null $mime
 * @property int|null $mime_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $supplement_size
 * @property string|null $supplement_hash
 * @property string|null $doc
 * @property int|null $alt_supplement
 * @property string|null $alt_mime
 * @property int|null $alt_mime_id
 * @property string|null $alt_state_link
 * @property int|null $alt_supplement_size
 * @property string|null $alt_supplement_hash
 * @property string|null $alt_doc
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class SupplementRecord extends Entity
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
        'supplement_id' => true,
        'bill_id' => true,
        'date' => true,
        'type_id' => true,
        'type' => true,
        'title' => true,
        'description' => true,
        'mime' => true,
        'mime_id' => true,
        'url' => true,
        'state_link' => true,
        'supplement_size' => true,
        'supplement_hash' => true,
        'doc' => true,
        'alt_supplement' => true,
        'alt_mime' => true,
        'alt_mime_id' => true,
        'alt_state_link' => true,
        'alt_supplement_size' => true,
        'alt_supplement_hash' => true,
        'alt_doc' => true,
        'created' => true,
        'modified' => true,
    ];
}
