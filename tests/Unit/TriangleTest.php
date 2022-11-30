<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * @dataProvider triangleProvider
     */
    public function test_triangle($a, $b, $c, $expectResult)
    {
        $result = $this->checkTriangle($a, $b, $c);
        $this->assertEquals($expectResult, $result);
    }

    public function triangleProvider()
    {
        return [
            "Không hợp lệ" => ["A", 2, 3, "Không hợp lệ"],
            "Không phải là tam giác" => [1, 2, 3, "Không phải là tam giác"],
            "Tam giác đều" => [3, 3, 3, "Tam giác đều"],
            "Tam giác cân" => [3, 3, 2, "Tam giác cân"],
            "Tam giác vuông" => [3, 4, 5, "Tam giác vuông"],
            "Tam giác thường" => [7, 8, 9, "Tam giác thường"],
        ];
    }

    public function checkTriangle($a, $b, $c)
    {
        if (!is_numeric($a) || !is_numeric($b) || !is_numeric($c)) {
            return "Không hợp lệ";
        } else if ($a + $b <= $c || $a + $c <= $b || $b + $c <= $a) {
            return "Không phải là tam giác";
        } else if ($a == $b && $b == $c) {
            return "Tam giác đều";
        } else if ($a == $b || $a == $c || $b == $c) {
            return "Tam giác cân";
        } else if ($a * $a + $b * $b == $c * $c || $a * $a + $c * $c == $b * $b || $b * $b + $c * $c == $a * $a) {
            return "Tam giác vuông";
        } else {
            return "Tam giác thường";
        }
    }
}
