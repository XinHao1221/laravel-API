<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();

// Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Verification
// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//     // Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);

//     Route::get(
//         '/email/verify/{id}/{hash}',
//         function (Request $request) {
//             $request->fulfill();

//             return response()->json([
//                 "message" => "Email verified."
//             ]);
//         }
//     )->middleware(['auth', 'signed'])->name('verification.verify');

//     Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
// });

// Verify email
// Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');

// // Resend link to verify email
// Route::post('/email/verify/resend', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

// Email verification
Route::prefix("/email/verify")->middleware(['throttle:6,1'])->group(function () {
    // Verify email
    Route::get('/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware('signed')->name('verification.verify');

    // Resend email verification
    Route::post('/resend', function (Request $request) {
        // Send verification link via email
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification link sent!'
        ]);
    })->middleware(['auth:sanctum'])->name('verification.send');
});

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        // Customers
        Route::apiResource('customers', CustomerController::class);
        Route::post('customers/bulk', [CustomerController::class, 'bulkStore']);
    }
);
