<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('temp');
});


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
})->name('patients.index');

// departments routes
Route::get('/departments', function () {
    return view('departments.index');
})->name('departments.index');

Route::get('/departments-add', function () {
    return view('departments.add');
})->name('departments.add');

Route::get('/departments-edit', function (){
    return view('departments.edit');
})->name('departments.edit');

// appointments routes
Route::get('/appointments', function () {
    return view('appointments.index');
})->name('appointments.index');

Route::get('storemp',[EmployeeController::class,'storemp'])->name('store-emp');
Route::get('update_user',[UserController::class,'update_user'])->name('update_user');
Route::post('employees/{id}/restore',[EmployeeController::class,'restore'])->name('employees.restore');
Route::get('employees/trash', [EmployeeController::class, 'trash'])->name('employees.trash');
Route::delete('employees/hardDelete/{id}', [EmployeeController::class, 'hardDelete'])->name('employees.hardDelete'); // الحذف النهائي
// employees.hardDelete

Route::resource('employees', EmployeeController::class);
Route::resource('users', UserController::class); 