<?php

namespace App\Modules\Mortgage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'extra_repayment_schedule';

    protected $fillable = [
        'loan_id',
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'extra_payment',
        'ending_balance',
        'remaining_loan_term',
    ];
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
