<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::apiResource('loans', LoanController::class)->only(['index', 'store', 'show']);

