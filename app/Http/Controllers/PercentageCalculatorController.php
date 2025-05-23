<?php

namespace App\Http\Controllers;

use App\Helpers\PercentageCalculatorHelper;
use Illuminate\Http\Request;

class PercentageCalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'sample_size' => 'required|numeric|min:1',
        ]);

        try {
            $percentage = PercentageCalculatorHelper::calculatePercentage(
                $request->value,
                $request->total
            );

            $marginError = PercentageCalculatorHelper::calculateMarginError(
                $request->sample_size
            );

            $confidenceInterval = PercentageCalculatorHelper::calculateConfidenceInterval(
                $percentage,
                $marginError
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'percentage' => round($percentage, 2),
                    'margin_error' => round($marginError, 2),
                    'confidence_interval' => [
                        'lower' => round($confidenceInterval['lower'], 2),
                        'upper' => round($confidenceInterval['upper'], 2)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
} 