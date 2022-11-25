<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderMethod extends Enum
{

    public const TIENMAT = 1;
    public const CHUYENKHOAN = 2;

    public static function getOrderMethod()
    {
        return [
            [
                'id' => self::TIENMAT,
                'name' => 'Thanh toán tiền mặt'
            ],
            [
                'id' => self::CHUYENKHOAN,
                'name' => 'Thanh toán chuyển khoản'
            ],
        ];
    }
}
