<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('temp');
});



Route::get('/doctors', function () {
    return view('doctors.index');
})->name('doctors.index');

Route::get('/doctors-edit', function () {
    return view('doctors.edit');
})->name('doctors.edit');

Route::get('/employees', function () {
    return view('employees.index');
})->name('employees.index');

Route::get('/employees-edit', function () {
    return view('employees.edit');
})->name('employees.edit');

Route::get('/employees-add', function () {
    return view('employees.add');
})->name('employees.add');