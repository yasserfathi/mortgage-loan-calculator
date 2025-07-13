<?PHP

use Illuminate\Support\Facades\Route;
use App\Modules\Mortgage\Controllers\LoanController;

Route::apiResource('loans', LoanController::class)->only(['index', 'store', 'show']);