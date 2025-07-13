<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MortgageLoanTest extends TestCase
{
    use RefreshDatabase;

    protected array $validPayload = [
        'principal' => 300000,
        'annual_interest_rate' => 5.0,
        'term_years' => 30,
        'extra_payment' => 100
    ];

    public function test_mortgage_loan_calculation_with_valid_data()
    {
        $response = $this->postJson('/api/loans', $this->validPayload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'loan' => [
                        'id',
                        'principal',
                        'annual_interest_rate',
                        'term_years',
                        'extra_payment',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_negative_numbers_fail()
    {
        $payload = [
            'principal' => -1000,
            'annual_interest_rate' => -5,
            'term_years' => -10,
            'extra_payment' => -50
        ];

        $response = $this->postJson('/api/loans', $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'principal',
                     'annual_interest_rate',
                     'term_years',
                     'extra_payment'
                 ]);
    }
}