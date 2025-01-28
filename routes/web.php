<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseFeeController;
use App\Http\Controllers\FeeTransactionController;
use App\Http\Controllers\ProffessorContoller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles
    Route::resource('roles', RoleController::class);

    // Users
    Route::resource('students', StudentController::class);

    // Batches 
    Route::resource('batches', BatchController::class);

    Route::resource('courses', CoursesController::class);

    Route::resource('course_fees', CourseFeeController::class);
    
    // routes/web.php
    Route::get('/get-course-details/{studentId}', [CourseFeeController::class, 'getCourseDetails']);

    // routes/web.php

    Route::middleware(['auth'])->group(function () {
        Route::get('/fee/transactions/create', [FeeTransactionController::class, 'create'])->name('fee_transactions.create');
        Route::post('/fee/transactions', [FeeTransactionController::class, 'store'])->name('fee_transactions.store');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/fee/transactions', [FeeTransactionController::class, 'index'])->name('fee_transactions.index');
    });

    Route::delete('/fee_transactions/{id}', [FeeTransactionController::class, 'destroy'])->name('fee_transactions.destroy');
    
    Route::get('/fee_transactions/{id}', [FeeTransactionController::class, 'show'])->name('fee_transactions.show');

    Route::resource('proffessors', ProffessorContoller::class);

});

require __DIR__ . '/auth.php';