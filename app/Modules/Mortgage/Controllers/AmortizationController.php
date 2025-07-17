<?php

namespace App\Modules\Mortgage\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Mortgage\Models\AmortizationSchedule;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AmortizationController extends Controller
{
    public function show($loan_id)
    {
        $data = AmortizationSchedule::select('month_number', 'starting_balance', 'monthly_payment', 'principal_component', 'interest_component', 'ending_balance')
            ->where('loan_id', $loan_id)->get();

        return response([
            'status' => 'success',
            'data' => $data,
        ], HttpResponse::HTTP_OK);
    }
}
