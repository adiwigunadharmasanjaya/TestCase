<?php

namespace Tests\Unit;

use App\Helpers\PercentageCalculatorHelper;
use Tests\TestCase;

class PercentageCalculatorHelperTest extends TestCase
{
    public function test_calculate_percentage()
    {
        $result = PercentageCalculatorHelper::calculatePercentage(50, 100);
        $this->assertEquals(50, $result);

        $result = PercentageCalculatorHelper::calculatePercentage(25, 200);
        $this->assertEquals(12.5, $result);
    }

    public function test_calculate_percentage_throws_exception_for_zero_total()
    {
        $this->expectException(\InvalidArgumentException::class);
        PercentageCalculatorHelper::calculatePercentage(50, 0);
    }

    public function test_calculate_margin_error()
    {
        $result = PercentageCalculatorHelper::calculateMarginError(100);
        $this->assertIsFloat($result);
        $this->assertGreaterThan(0, $result);
    }

    public function test_calculate_margin_error_throws_exception_for_invalid_sample_size()
    {
        $this->expectException(\InvalidArgumentException::class);
        PercentageCalculatorHelper::calculateMarginError(0);
    }

    public function test_calculate_confidence_interval()
    {
        $percentage = 50;
        $marginError = 5;
        
        $result = PercentageCalculatorHelper::calculateConfidenceInterval($percentage, $marginError);
        
        $this->assertEquals(45, $result['lower']);
        $this->assertEquals(55, $result['upper']);
    }

    public function test_confidence_interval_bounds()
    {
        $result = PercentageCalculatorHelper::calculateConfidenceInterval(2, 5);
        $this->assertEquals(0, $result['lower']); // Tidak boleh negatif

        $result = PercentageCalculatorHelper::calculateConfidenceInterval(98, 5);
        $this->assertEquals(100, $result['upper']); // Tidak boleh lebih dari 100
    }
} 