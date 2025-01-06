<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;

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

// Public routes of authentication

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//Protected routes of logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::get('my-appointments', [AppointmentController::class, 'myAppointments']);
    Route::get('my-prescriptions', [PatientController::class, 'getMyPrescriptions']);
    Route::get('active-departments', [PatientController::class, 'getActiveDepartments']);
    Route::get('active-doctors/{departmentId}', [PatientController::class, 'getAvailableDoctorsInDepartment']);
    Route::get('available-slots/{doctorId}/{dayOfWeek}', [AppointmentController::class, 'getAvailableSlots']);
});

//Ratings routes  ->middleware('auth:sanctum')
Route::post('doctor_ratings', [RatingController::class, 'doctor_ratings_details']);
Route::apiResource('rating', RatingController::class);
