<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\ExtraRepaymentSchedule;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\AmortizationSchedule;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['amortizationSchedule', 'extraRepaymentSchedule']);

        if ($request->boolean('paginate', false)) {
            $perPage = $request->input('per_page', 10);
            $loans = $query->paginate($perPage);
        } else {
            $loans = $query->get();
        }

        return response([
            'status' => 'success',
            'data' => $loans
        ])->setStatusCode(HttpResponse::HTTP_OK);
    }

    public function store(LoanRequest $request)
    {
        $validated = $request->validated();
        $loan = Loan::create($validated);
        $monthlyRate = ($loan->annual_interest_rate / 12) / 100;
        $months = $loan->term_years * 12;

        $monthlyPayment = ($loan->principal * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$months));

        $balance = $loan->principal;
        for ($i = 1; $i <= $months; $i++) {
            $interest = $balance * $monthlyRate;
            $principal = $monthlyPayment - $interest;
            $ending = $balance - $principal;

            AmortizationSchedule::create([
                'loan_id' => $loan->id,
                'month_number' => $i,
                'starting_balance' => $balance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principal,
                'interest_component' => $interest,
                'ending_balance' => $ending,
            ]);

            $balance = $ending;

            if ($balance <= 0) break;
        }

        if ($loan->monthly_extra_payment > 0) {
            $balance = $loan->principal;
            $month = 1;

            while ($balance > 0) {
                $interest = $balance * $monthlyRate;
                $principal = $monthlyPayment - $interest;
                $totalPrincipal = $principal + $loan->monthly_extra_payment;
                $ending = $balance - $totalPrincipal;

                ExtraRepaymentSchedule::create([
                    'loan_id' => $loan->id,
                    'month_number' => $month,
                    'starting_balance' => $balance,
                    'monthly_payment' => $monthlyPayment,
                    'principal' => $principal,
                    'interest' => $interest,
                    'extra_repayment' => $loan->monthly_extra_payment,
                    'ending_balance' => max($ending, 0),
                    'remaining_loan_term' => null, // optional
                ]);

                $balance = $ending;
                $month++;
            }
        }

        return response([
            'status' => 'success',
            'message' => 'Loan is successfully created',
            'data' => [
                'loan' => $loan,
                'monthly_payment' => round($monthlyPayment, 2),
                'loan_term_months' => $months,
            ],
        ])->setStatusCode(HttpResponse::HTTP_CREATED);
    }

    public function show(Loan $loan)
    {
        $loan->load(['amortizationSchedule', 'extraRepaymentSchedule']);

        return response([
            'status' => 'success',
            'data' => $loan,
        ])->setStatusCode(HttpResponse::HTTP_OK);
    }
}
