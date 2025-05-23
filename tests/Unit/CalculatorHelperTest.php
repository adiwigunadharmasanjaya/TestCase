<?php

namespace Tests\Unit;

use App\Helpers\CalculatorHelper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CalculatorHelperTest extends TestCase
{
    public function testAddition()
    {
        $this->assertEquals(5, CalculatorHelper::add(2, 3));
    }

    public function testSubtraction()
    {
        $this->assertEquals(1, CalculatorHelper::subtract(4, 3));
    }

    public function testMultipleTestCase()
    {
        $cases = [
            [2, 3, 5],
            [0, 0, 0],
            [-1, 1, 0],
            [10, 5, 15],
        ];

        foreach ($cases as [$a, $b, $expected]) {
            $this->assertEquals($expected, CalculatorHelper::add($a, $b), "Failed on: $a + $b");
        }
    }

    #[DataProvider('additionProvider')]
    public function testAdditionWithDataProvider($a, $b, $expected)
    {
        $this->assertEquals($expected, CalculatorHelper::add($a, $b));
    }

    public static function additionProvider()
    {
        return [
            [2, 3, 5],
            [0, 0, 0],
            [-1, 1, 0],
            [10, 5, 15],
        ];
    }
}
