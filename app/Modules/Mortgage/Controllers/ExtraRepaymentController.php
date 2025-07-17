<?php

namespace App\Modules\Mortgage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mortgage\Models\ExtraRepaymentSchedule;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ExtraRepaymentController extends Controller
{
    public function show($loan_id)
    {
         $data = ExtraRepaymentSchedule::select('month_number', 'starting_balance', 'monthly_payment', 'principal_component','interest_component','extra_payment', 'ending_balance','remaining_loan_term')
            ->where('loan_id', $loan_id)->get();

        return response([
            'status' => 'success',
            'data' => $data,
        ], HttpResponse::HTTP_OK);
    }
}
