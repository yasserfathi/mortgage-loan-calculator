<?php

namespace App\Modules\Mortgage\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation(): void
    {
        $this->merge([
            'extra_payment' => $this->input('extra_payment', 0),
        ]);
    }
    public function rules(): array
    {
        return [
            'principal' => ['required', 'numeric', 'min:0'],
            'annual_interest_rate' => ['required', 'numeric', 'min:0'],
            'term_years' => ['required', 'integer', 'min:1'],
            'extra_payment' => ['nullable', 'numeric', 'min:0'],
            'total_interest_paid' => ['nullable', 'numeric', 'min:0'],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'validation_error',
            'errors' => $validator->errors()
        ], 422));
    }
    public function messages(): array
    {
        return [
            'principal.required' => 'The loan principal amount is required.',
            'principal.numeric' => 'The principal must be a valid number.',
            'principal.min' => 'The principal must be 0 or greater.',

            'annual_interest_rate.required' => 'The interest rate is required.',
            'annual_interest_rate.numeric' => 'The interest rate must be a number.',
            'annual_interest_rate.min' => 'The interest rate must be 0 or greater.',

            'term_years.required' => 'The loan term (in years) is required.',
            'term_years.integer' => 'The loan term must be an integer.',
            'term_years.min' => 'The loan term must be at least 1 year.',

            'extra_payment.numeric' => 'The extra payment must be a number.',
            'extra_payment.min' => 'The extra payment cannot be negative.',
        ];
    }
}