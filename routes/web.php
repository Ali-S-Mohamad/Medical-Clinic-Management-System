<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
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



Route::get('/dashboard', function () {
    return view('temp');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// doctors routes
Route::get('/doctors', function () {
    return view('doctors.index');
})->name('doctors.index');

Route::get('/doctors-edit', function () {
    return view('doctors.edit');
})->name('doctors.edit');


// employees routes
Route::get('/employees', function () {
    return view('employees.index');
})->name('employees.index');

Route::get('/employees-edit', function () {
    return view('employees.edit');
})->name('employees.edit');

Route::get('/employees-add', function () {
    return view('employees.add');
})->name('employees.add');

// patients routes
Route::get('/patients', function () {
    return view('patients.index');
})->name('patients.index');

// departments routes
Route::resource('/departments', DepartmentController::class);
Route::get('trash', [DepartmentController::class, 'trash'])->name('departments.trash');
Route::put('/departments/restore/{id}', [DepartmentController::class, 'restore'])->name('departments.restore');
Route::delete('/departments/hard-delete/{id}', [DepartmentController::class, 'hardDelete'])->name('departments.hardDelete'); // الحذف النهائي
Route::patch('/departments/{id}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('departments.toggleStatus');

// end 

// appointments routes
Route::get('/appointments', function () {
    return view('appointments.index');
})->name('appointments.index');

