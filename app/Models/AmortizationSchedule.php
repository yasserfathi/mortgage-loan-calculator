<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmortizationSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'loan_amortization_schedule';

    protected $fillable = [
        'loan_id',
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'ending_balance',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
