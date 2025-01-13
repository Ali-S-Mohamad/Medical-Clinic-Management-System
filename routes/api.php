<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\DepartmentController;
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

    Route::get('list-departments', [DepartmentController::class, 'listDepartments']);
    Route::get('show-department/{department}', [DepartmentController::class, 'showDepartment']);
    Route::get('active-departments', [DepartmentController::class, 'getActiveDepartments']);

    Route::get('active-doctors/{departmentId}', [DepartmentController::class, 'getAvailableDoctorsInDepartment']);
    Route::get('all-doctors', [DoctorController::class, 'listDoctors']);
    Route::get('show-doctor/{doctor}', [DoctorController::class, 'showDoctor']);

    Route::get('available-slots/{doctorId}/{dayOfWeek}', [AppointmentController::class, 'getAvailableSlots']);

    Route::get('patients/{patientId}/reports', [ReportController::class, 'getPatientReports']);
    Route::get('patients/{patientId}/reports/export', [ReportController::class, 'exportPatientReports']);
    Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'canceledAppointment']);

    Route::get('my-ratings', [RatingController::class, 'getMyRatings']);

});

//Ratings routes  ->middleware('auth:sanctum')
Route::post('doctor_ratings', [RatingController::class, 'doctorRatingsDetails']);
Route::get('clinic-info', [DepartmentController::class, 'getClinicInfo']);
Route::apiResource('rating', RatingController::class);
