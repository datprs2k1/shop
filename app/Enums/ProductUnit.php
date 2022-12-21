<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProductUnit extends Enum
{
    public const CAI = 1;
    public const CHAI = 2;
    public const HOP = 3;
    public const KHAY = 4;
    public const QUA = 5;
    public const KILOGRAM = 6;
    public const TUI = 7;
    public const GOI = 8;
    public const CAN = 9;

    public static function getProductUnit()
    {
        return [
            [
                'id' => self::CAI,
                'name' => 'Cái'
            ],
            [
                'id' => self::CHAI,
                'name' => 'Chai'
            ],
            [
                'id' => self::HOP,
                'name' => 'Hộp'
            ],
            [
                'id' => self::KHAY,
                'name' => 'Khay'
            ],
            [
                'id' => self::QUA,
                'name' => 'Quả'
            ],
            [
                'id' => self::KILOGRAM,
                'name' => 'KG'
            ],
            [
                'id' => self::TUI,
                'name' => 'Túi'
            ],
            [
                'id' => self::GOI,
                'name' => 'Gói'
            ],
            [
                'id' => self::CAN,
                'name' => 'Can'
            ],
        ];
    }
}
