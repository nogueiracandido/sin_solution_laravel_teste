<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::prefix('student')->group(function () {
        Route::get('/', [App\Http\Controllers\StudentController::class, 'index']);
        Route::post('/', [App\Http\Controllers\StudentController::class, 'store']);
        Route::put('/', [App\Http\Controllers\StudentController::class, 'update']);
        Route::delete('/', [App\Http\Controllers\StudentController::class, 'destroy']);
        Route::get('/create', [App\Http\Controllers\StudentController::class, 'create']);
        Route::get('/edit/{id}', [App\Http\Controllers\StudentController::class, 'edit']);
        Route::get('/report/{id}', [App\Http\Controllers\StudentController::class, 'report']);
    });

    Route::prefix('adress')->group(function () {
        Route::get('/', [App\Http\Controllers\AdressController::class, 'index']);
        Route::post('/', [App\Http\Controllers\AdressController::class, 'store']);
        Route::put('/', [App\Http\Controllers\AdressController::class, 'update']);
        Route::delete('/', [App\Http\Controllers\AdressController::class, 'destroy']);
        Route::get('/create', [App\Http\Controllers\AdressController::class, 'create']);
        Route::get('/edit/{id}', [App\Http\Controllers\AdressController::class, 'edit']);
    });

    Route::prefix('classroom')->group(function () {
        Route::get('/', [App\Http\Controllers\ClassroomController::class, 'index']);
        Route::post('/', [App\Http\Controllers\ClassroomController::class, 'store']);
        Route::put('/', [App\Http\Controllers\ClassroomController::class, 'update']);
        Route::delete('/', [App\Http\Controllers\ClassroomController::class, 'destroy']);
        Route::get('/create', [App\Http\Controllers\ClassroomController::class, 'create']);
        Route::get('/edit/{id}', [App\Http\Controllers\ClassroomController::class, 'edit']);
        Route::get('/report/{id}', [App\Http\Controllers\ClassroomController::class, 'report']);
    });

    Route::prefix('registration')->group(function () {
        Route::get('/', [App\Http\Controllers\RegistrationController::class, 'index']);
        Route::post('/', [App\Http\Controllers\RegistrationController::class, 'store']);
        Route::put('/', [App\Http\Controllers\RegistrationController::class, 'update']);
        Route::delete('/', [App\Http\Controllers\RegistrationController::class, 'destroy']);
        Route::get('/create', [App\Http\Controllers\RegistrationController::class, 'create']);
        Route::get('/edit/{id}', [App\Http\Controllers\RegistrationController::class, 'edit']);
    });
});
