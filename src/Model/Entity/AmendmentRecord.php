<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AmendmentRecord Entity
 *
 * @property int $id
 * @property int|null $amendment_id
 * @property int|null $bill_id
 * @property int|null $adopted
 * @property string|null $chamber
 * @property int|null $chamber_id
 * @property \Cake\I18n\Date|null $date
 * @property string|null $title
 * @property string|null $description
 * @property string|null $mime
 * @property int|null $mime_id
 * @property string|null $url
 * @property string|null $state_link
 * @property int|null $amendment_size
 * @property string|null $amendment_hash
 * @property string|null $doc
 * @property int|null $alt_amendment
 * @property string|null $alt_mime
 * @property int|null $alt_mime_id
 * @property string|null $alt_state_link
 * @property int|null $alt_amendment_size
 * @property string|null $alt_amendment_hash
 * @property string|null $alt_doc
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property \Cake\I18n\Date $last_sync
 */
class AmendmentRecord extends Entity
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
        'amendment_id' => true,
        'bill_id' => true,
        'adopted' => true,
        'chamber' => true,
        'chamber_id' => true,
        'date' => true,
        'title' => true,
        'description' => true,
        'mime' => true,
        'mime_id' => true,
        'url' => true,
        'state_link' => true,
        'amendment_size' => true,
        'amendment_hash' => true,
        'doc' => true,
        'alt_amendment' => true,
        'alt_mime' => true,
        'alt_mime_id' => true,
        'alt_state_link' => true,
        'alt_amendment_size' => true,
        'alt_amendment_hash' => true,
        'alt_doc' => true,
        'created' => true,
        'modified' => true,
        'last_sync' => true,
    ];
}
