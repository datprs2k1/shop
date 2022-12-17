<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InventoryStatusEnum extends Enum
{
    public const CON_HANG = 1;
    public const HET_HANG = 2;

    public static function getInventoryStatus()
    {
        return [
            [
                'id' => self::CON_HANG,
                'name' => 'Còn hàng',
            ],
            [
                'id' => self::HET_HANG,
                'name' => 'Hết hàng',
            ]
        ];
    }
}
