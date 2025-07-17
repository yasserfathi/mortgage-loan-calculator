<?PHP

use Illuminate\Support\Facades\Route;
use App\Modules\Mortgage\Controllers\LoanController;
use App\Modules\Mortgage\Controllers\AmortizationController;
use App\Modules\Mortgage\Controllers\ExtraRepaymentController;

Route::prefix('loans')->group(function () {
    Route::apiResource('/', LoanController::class)->only(['index', 'store']);
    Route::get('total', [LoanController::class, 'total'])->name('loans.total');
});
Route::get('amortization/{loan_in}', [AmortizationController::class, 'show'])->name('amortization.show');
Route::get('extra_payment/{loan_in}', [ExtraRepaymentController::class, 'show'])->name('extra_payment.show');