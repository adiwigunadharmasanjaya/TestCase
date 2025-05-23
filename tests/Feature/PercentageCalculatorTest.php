<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PercentageCalculatorTest extends TestCase
{
    public function test_can_access_calculator_page()
    {
        $response = $this->get(route('calculator.index'));
        $response->assertStatus(200);
    }

    public function test_can_calculate_percentage()
    {
        $data = [
            'value' => 50,
            'total' => 100,
            'sample_size' => 100
        ];

        $response = $this->postJson(route('calculator.calculate'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'percentage' => 50.0,
                    'margin_error' => 9.8,
                    'confidence_interval' => [
                        'lower' => 40.2,
                        'upper' => 59.8
                    ]
                ]
            ]);
    }

    public function test_validates_required_fields()
    {
        $response = $this->postJson(route('calculator.calculate'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value', 'total', 'sample_size']);
    }

    public function test_validates_numeric_fields()
    {
        $data = [
            'value' => 'invalid',
            'total' => 'invalid',
            'sample_size' => 'invalid'
        ];

        $response = $this->postJson(route('calculator.calculate'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value', 'total', 'sample_size']);
    }

    public function test_validates_minimum_values()
    {
        $data = [
            'value' => -1,
            'total' => -1,
            'sample_size' => 0
        ];

        $response = $this->postJson(route('calculator.calculate'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value', 'total', 'sample_size']);
    }
} 