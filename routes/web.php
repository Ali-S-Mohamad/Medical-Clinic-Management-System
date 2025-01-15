<?php


use App\Models\Rating;
use App\Models\ClinicInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClinicInfoController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalFilesController;
use App\Http\Controllers\PrescriptionsController;

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
// Route::get('/export-patients', function () {
//     return Excel::download(new PatientsExport, 'patients.xlsx');
// });

Auth::routes();

Route::middleware(['auth','patient'])->group(function () {


    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Define Role Resource Routes
    Route::resource('roles', RoleController::class);


    //Define prescriptions Routes
    Route::get('/prescriptions/trash', [PrescriptionsController::class, 'trash'])->name('prescriptions.trash');
    Route::post('prescriptions/restore/{id}', [PrescriptionsController::class, 'restore'])->name('prescriptions.restore');
    Route::delete('/prescriptions/force-delete/{id}', [PrescriptionsController::class, 'forceDelete'])->name('prescriptions.forceDelete');
    Route::resource('prescriptions', PrescriptionsController::class);


    //Define MedicalFiles Routes
    Route::get('/medicalFiles/trash', [MedicalFilesController::class, 'trash'])->name('medicalFiles.trash');
    Route::post('medicalFiles/restore/{id}', [MedicalFilesController::class, 'restore'])->name('medicalFiles.restore');
    Route::delete('/medicalFiles/force-delete/{id}', [MedicalFilesController::class, 'forceDelete'])->name('medicalFiles.forceDelete');
    Route::resource('/medicalFiles', MedicalFilesController::class);


    //Define Departments Routes
    Route::get('/departments/trash', [DepartmentController::class, 'trash'])->name('departments.trash');
    Route::put('/departments/restore/{id}', [DepartmentController::class, 'restore'])->name('departments.restore');
    Route::delete('/departments/force-delete/{id}', [DepartmentController::class, 'forceDelete'])->name('departments.forceDelete'); // الحذف النهائي
    Route::patch('/departments/{id}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('departments.toggleStatus');
    Route::resource('/departments', DepartmentController::class);


    //Define Appointments Routes
    Route::resource('/appointments', AppointmentController::class);
    Route::resource('/time-slots', TimeSlotController::class);
    Route::patch('/time-slots/{id}/toggle-Availability', [TimeSlotController::class, 'toggleAvailability'])->name('time-slots.toggleAvailability');
    Route::get('/get-available-slots/{doctorId}/{appointmentDate}', [AppointmentController::class, 'getAvailableSlots']);




    //Define Employees Routes
    Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::get('employees/trash', [EmployeeController::class, 'trash'])->name('employees.trash');
    Route::delete('employees/force-delete/{id}', [EmployeeController::class, 'forceDelete'])->name('employees.forceDelete'); // الحذف النهائي
    Route::resource('employees', EmployeeController::class);


    //Define Users Routes
    Route::get('update_user', [UserController::class, 'update_user'])->name('update_user');
    Route::resource('users', UserController::class);


    //Define Patients Routes
    Route::post('patients/{id}/restore', [PatientController::class, 'restore'])->name('patients.restore');
    Route::get('patients/trash', [PatientController::class, 'trash'])->name('patients.trash');
    Route::delete('patients/force-delete/{id}', [PatientController::class, 'forceDelete'])->name('patients.forceDelete'); // الحذف النهائي
    Route::resource('patients', PatientController::class);


    //Define Admin Dashboard Routes
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:Admin');;


    //Define ClinicInfo Routes
    Route::resource('clinic', ClinicInfoController::class);


    //Define Ratings Routes
    Route::resource('ratings', RatingController::class);


    //Define Reports Routes
    Route::get('/reports/trash', [ReportController::class, 'trash'])->name('reports.trash');
    Route::post('/reports/restore/{id}', [ReportController::class, 'restore'])->name('reports.restore');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/export-reports', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/export/{id}', [ReportController::class, 'exportSingle'])->name('reports.exportOne');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
    Route::delete('reports/force-delete/{id}', [ReportController::class, 'forceDelete'])->name('reports.forceDelete'); // الحذف النهائي


    Route::get('/error/403', function() {
        return view ('errors.errors403');     })->name('error.403');

});