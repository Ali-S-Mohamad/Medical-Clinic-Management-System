<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/verify-callback', function (Request $request) {
    // مثال على التعامل مع رد Telegram Gateway
    if ($request->status === 'verified') {
        // تحديث حالة المستخدم (مثلاً: جعله مفعلًا)
        $user = Usgit er::where('phone_number', $request->phone_number)->first();
        if ($user) {
            $user->update(['is_verified' => true]);
        }

        return response()->json(['message' => 'User verified successfully']);
    }

    return response()->json(['error' => 'Verification failed'], 400);
})->name('verify.callback');

// Public routes of authtication

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//Protected routes of logout
Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
});
