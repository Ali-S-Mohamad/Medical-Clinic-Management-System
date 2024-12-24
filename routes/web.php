<?php


use App\Http\Controllers\PatientController;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\PrescriptionsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Models\Rating;



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



// Route::get('/dashboard', function () {
//     return view('dashoard');
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Define Role Resource Routes
Route::resource('roles', RoleController::class);

//Define prescriptions Routes
Route::get('/prescriptions/trash', [PrescriptionsController::class, 'trash'])->name('prescriptions.trash');
Route::post('prescriptions/restore/{id}', [PrescriptionsController::class, 'restore'])->name('prescriptions.restore');
Route::delete('/prescriptions/hard-delete/{id}', [PrescriptionsController::class, 'hardDelete'])->name('prescriptions.hardDelete');
Route::resource('prescriptions', PrescriptionsController::class);



// doctors routes
Route::get('/doctors', function () {
    return view('doctors.index');
})->name('doctors.index');

Route::get('/doctors-edit', function () {
    return view('doctors.edit');
})->name('doctors.edit');

// patients routes
Route::get('/patients', function () {
    return view('patients.index');
})->name('patients.index')->middleware('auth');

// departments routes
Route::resource('/departments', DepartmentController::class);
Route::get('trash', [DepartmentController::class, 'trash'])->name('departments.trash');
Route::put('/departments/restore/{id}', [DepartmentController::class, 'restore'])->name('departments.restore');
Route::delete('/departments/hard-delete/{id}', [DepartmentController::class, 'hardDelete'])->name('departments.hardDelete'); // الحذف النهائي
Route::patch('/departments/{id}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('departments.toggleStatus');
// end

// appointments routes
Route::resource('/appointments', AppointmentController::class);

Route::get('update_user', [UserController::class, 'update_user'])->name('update_user');
Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
Route::get('employees/trash', [EmployeeController::class, 'trash'])->name('employees.trash');
Route::delete('employees/hardDelete/{id}', [EmployeeController::class, 'hardDelete'])->name('employees.hardDelete'); // الحذف النهائي

Route::resource('users', UserController::class);
Route::resource('employees', EmployeeController::class);

// Patients Routes
Route::resource('patients', PatientController::class)->middleware('auth');
Route::get('patients/trash', [PatientController::class, 'trash'])->name('patients.trash');


// Admin dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/testr', function () {
    $rating = new Rating;
    $rating->employee_id   = 4;
    $rating->patient_id  = 2;
    $rating->doctor_rate = 4;
    $rating->save();
    //  $user = User::find($rating->employee_id);
    //  $roles=$user->getRoleNames();
    //  foreach($roles as $role)
    //     if($role =='doctor')
    //        dd('doctor');
    //     else dd('employess');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
