<?php

namespace App\Modules\Mortgage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'principal',
        'annual_interest_rate',
        'term_years',
        'extra_payment',
        'total_interest_paid'
    ];

    protected $casts = [
        'principal' => 'decimal:2',
        'annual_interest_rate' => 'decimal:2',
        'extra_payment' => 'decimal:2',
        'total_interest_paid' => 'decimal:2',
        'created_at' => 'datetime:Y-m-d',
        'deleted_at' => 'datetime:Y-m-d',
    ];

    public function amortizationSchedule()
    {
        return $this->hasMany(AmortizationSchedule::class);
    }

    public function extraRepaymentSchedule()
    {
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }

}
