<?php

namespace App\Helpers;

class PercentageCalculatorHelper
{
    /**
     * Menghitung persentase dari nilai
     * 
     * @param float $value Nilai yang akan dihitung persentasenya
     * @param float $total Total nilai
     * @return float
     */
    public static function calculatePercentage(float $value, float $total): float
    {
        if ($total == 0) {
            throw new \InvalidArgumentException('Total tidak boleh 0');
        }
        return ($value / $total) * 100;
    }

    /**
     * Menghitung margin error
     * 
     * @param float $sampleSize Ukuran sampel
     * @param float $confidenceLevel Tingkat kepercayaan (dalam desimal, misal 0.95 untuk 95%)
     * @return float
     */
    public static function calculateMarginError(float $sampleSize, float $confidenceLevel = 0.95): float
    {
        if ($sampleSize <= 0) {
            throw new \InvalidArgumentException('Ukuran sampel harus lebih besar dari 0');
        }

        // Z-score untuk tingkat kepercayaan 95% adalah 1.96
        $zScore = 1.96;
        $standardError = sqrt(0.25 / $sampleSize);
        
        return $zScore * $standardError * 100;
    }

    /**
     * Menghitung interval kepercayaan
     * 
     * @param float $percentage Persentase yang dihitung
     * @param float $marginError Margin error
     * @return array
     */
    public static function calculateConfidenceInterval(float $percentage, float $marginError): array
    {
        return [
            'lower' => max(0, $percentage - $marginError),
            'upper' => min(100, $percentage + $marginError)
        ];
    }
} 