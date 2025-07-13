<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Models\AmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['amortizationSchedule', 'extraRepaymentSchedule']);

        $loans = $request->boolean('paginate')
            ? $query->paginate($request->input('per_page', 10))
            : $query->get();

        return response([
            'status' => 'success',
            'data' => $loans
        ], HttpResponse::HTTP_OK);
    }

    public function store(LoanRequest $request)
    {
        $loan = Loan::create($request->validated());

        $monthlyRate = ($loan->annual_interest_rate / 12) / 100;
        $months = $loan->term_years * 12;
        $balance = round((float)$loan->principal, 2);

        $monthlyPayment = round(
            ($loan->principal * $monthlyRate) /
            (1 - pow(1 + $monthlyRate, -$months)), 2
        );

        $loan->extra_payment = round($loan->extra_payment ?? 0, 2);

        $loan->extra_payment > 0
            ? $this->generateExtraRepaymentSchedule($loan, $monthlyPayment, $monthlyRate, $balance)
            : $this->generateStandardAmortizationSchedule($loan, $monthlyPayment, $monthlyRate, $months, $balance);

        // ✅ Calculate total interest paid after creating schedule
        $totalInterest = $loan->extra_payment > 0
            ? ExtraRepaymentSchedule::where('loan_id', $loan->id)->sum('interest_component')
            : AmortizationSchedule::where('loan_id', $loan->id)->sum('interest_component');

        $loan->update(['total_interest_paid' => round($totalInterest, 2)]);

        return response([
            'status' => 'success',
            'message' => 'Loan successfully created.',
            'data' => [
                'loan' => $loan,
                'monthly_payment' => $monthlyPayment,
                'loan_term_months' => $months,
                'total_interest_paid' => round($totalInterest, 2),
            ],
        ], HttpResponse::HTTP_CREATED);
    }

    protected function generateStandardAmortizationSchedule($loan, $monthlyPayment, $monthlyRate, $months, $balance)
    {
        for ($i = 1; $i <= $months && $balance > 0; $i++) {
            $interest = round($balance * $monthlyRate, 2);
            $principal = round($monthlyPayment - $interest, 2);
            $ending = round($balance - $principal, 2);

            AmortizationSchedule::create([
                'loan_id' => $loan->id,
                'month_number' => $i,
                'starting_balance' => $balance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principal,
                'interest_component' => $interest,
                'ending_balance' => max($ending, 0),
            ]);

            $balance = $ending;
        }
    }

    protected function generateExtraRepaymentSchedule($loan, $monthlyPayment, $monthlyRate, $balance)
    {
        $month = 1;
        $extra = $loan->extra_payment;
        $remainingLoanTerm = ceil($balance / ($monthlyPayment + $extra));

        while ($balance > 0) {
            $interest = round($balance * $monthlyRate, 2);
            $principal = round($monthlyPayment - $interest, 2);
            $totalPrincipal = $principal + $extra;
            $ending = round($balance - $totalPrincipal, 2);

            ExtraRepaymentSchedule::create([
                'loan_id' => $loan->id,
                'month_number' => $month,
                'starting_balance' => $balance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principal,
                'interest_component' => $interest,
                'extra_payment' => $extra,
                'ending_balance' => max($ending, 0),
                'remaining_loan_term' => max($remainingLoanTerm - $month + 1, 0),
            ]);

            $balance = $ending;
            $month++;
        }
    }

    public function show(Loan $loan)
    {
        $loan->load(['amortizationSchedule', 'extraRepaymentSchedule']);

        return response([
            'status' => 'success',
            'data' => $loan,
        ], HttpResponse::HTTP_OK);
    }
}
