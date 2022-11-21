<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProductStatus extends Enum
{
    public const AVAIABLE = 0;
    public const OUT_OF_STOCK = 1;
    public const COMMING_SOON = 2;

    public static function getProductStatus()
    {
        return [
            [
                'id' => self::AVAIABLE,
                'name' => 'Còn hàng'
            ],
            [
                'id' => self::OUT_OF_STOCK,
                'name' => 'Hết hàng'
            ],
            [
                'id' => self::COMMING_SOON,
                'name' => 'Sắp có hàng'
            ],
        ];
    }
}
