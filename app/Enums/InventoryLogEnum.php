<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InventoryLogEnum extends Enum
{
    public const DA_BAN = 1;
    public const HUY = 2;
    public const NHAP = 3;

    public static function getInventoryLogStatus()
    {
        return [
            [
                'id' => self::DA_BAN,
                'name' => 'Đã bán',
            ],
            [
                'id' => self::HUY,
                'name' => 'Đã huỷ',
            ],
            [
                'id' => self::NHAP,
                'name' => 'Đã nhập',
            ],
        ];
    }
}
