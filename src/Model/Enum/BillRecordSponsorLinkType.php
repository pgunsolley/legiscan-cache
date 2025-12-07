<?php
declare(strict_types=1);

namespace App\Model\Enum;

use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

/**
 * BillRecordSponsorLinkType Enum
 */
enum BillRecordSponsorLinkType: string implements EnumLabelInterface
{
    case Official = 'official';
    case Personal = 'personal';

    /**
     * @return string
     */
    public function label(): string
    {
        return Inflector::humanize(Inflector::underscore($this->name));
    }
}
