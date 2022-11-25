<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    public const DANGXULY = 0;
    public const DADUYET  = 1;
    public const DAHUY    = 2;

    public static function getOrderStatus()
    {
        return [
            [
                'id'   => self::DANGXULY,
                'name' => 'Đang xử lý',
            ],
            [
                'id'   => self::DADUYET,
                'name' => 'Đã duyệt',
            ],
            [
                'id'   => self::DAHUY,
                'name' => 'Đã hủy',
            ],
        ];
    }
}
