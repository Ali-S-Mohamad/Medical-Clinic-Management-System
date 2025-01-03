<?php


use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MedicalFilesController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    //Define Role Resource Routes
    Route::resource('roles', RoleController::class);


    //Define prescriptions Routes
    Route::get('/prescriptions/trash', [PrescriptionsController::class, 'trash'])->name('prescriptions.trash');
    Route::post('prescriptions/restore/{id}', [PrescriptionsController::class, 'restore'])->name('prescriptions.restore');
    Route::delete('/prescriptions/hard-delete/{id}', [PrescriptionsController::class, 'hardDelete'])->name('prescriptions.hardDelete');
    Route::resource('prescriptions', PrescriptionsController::class);


    //Define MedicalFiles Routes
    Route::get('/medicalFiles/trash', [MedicalFilesController::class, 'trash'])->name('medicalFiles.trash');
    Route::post('medicalFiles/restore/{id}', [MedicalFilesController::class, 'restore'])->name('medicalFiles.restore');
    Route::delete('/medicalFiles/hard-delete/{id}', [MedicalFilesController::class, 'hardDelete'])->name('medicalFiles.hardDelete');
    Route::resource('/medicalFiles', MedicalFilesController::class);


    //Define Departments Routes
    Route::resource('/departments', DepartmentController::class);
    Route::get('trash', [DepartmentController::class, 'trash'])->name('departments.trash');
    Route::put('/departments/restore/{id}', [DepartmentController::class, 'restore'])->name('departments.restore');
    Route::delete('/departments/hard-delete/{id}', [DepartmentController::class, 'hardDelete'])->name('departments.hardDelete'); // الحذف النهائي
    Route::patch('/departments/{id}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('departments.toggleStatus');


    //Define Appointments Routes
    Route::resource('/appointments', AppointmentController::class);


    //Define Users Routes
    Route::resource('users', UserController::class);


    //Define Employees Routes
    Route::get('update_user', [UserController::class, 'update_user'])->name('update_user');
    Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::get('employees/trash', [EmployeeController::class, 'trash'])->name('employees.trash');
    Route::delete('employees/hardDelete/{id}', [EmployeeController::class, 'hardDelete'])->name('employees.hardDelete'); // الحذف النهائي
    Route::resource('employees', EmployeeController::class);


    //Define Patients Routes
    Route::resource('patients', PatientController::class);
    Route::get('patients/trash', [PatientController::class, 'trash'])->name('patients.trash');


    //Define Admin Dashboard Routes
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:Admin');;


    //Define Ratings Routes
    Route::resource('ratings', RatingController::class);
});
