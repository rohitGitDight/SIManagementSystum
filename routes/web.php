<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProffessorContoller;
use App\Http\Controllers\StudentFeeTransactionController;
use App\Http\Controllers\StudentCourseFeeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InvoiceController;

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

    // routes/web.php

    Route::resource('proffessors', ProffessorContoller::class);

    // routes/web.php
    Route::get('/get-batches/{courseId}', [StudentController::class, 'getBatches']);
    Route::get('/get-professors/{courseId}', [StudentController::class, 'getProfessors']);
    Route::get('/get-courseFee/{courseId}', [StudentController::class, 'getCourseFee']);


    Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
    
    Route::get('/student_fee_transactions', [StudentFeeTransactionController::class, 'index'])->name('student_fee_transactions.index');
    Route::get('/student_fee_transactions/create', [StudentFeeTransactionController::class, 'create'])->name('student_fee_transactions.create');
    Route::post('/student_fee_transactions/store', [StudentFeeTransactionController::class, 'store'])->name('student_fee_transactions.store');
    
    Route::get('/student-course-fees', [StudentCourseFeeController::class, 'index'])->name('student_course_fees.index');
    Route::get('student_course_fees/{id}', [StudentCourseFeeController::class, 'show'])->name('student_course_fees.show');
    
    Route::get('/student-course-fees/calendar', [CalendarController::class, 'index'])->name('student_course_fees.calendar');

    Route::post('/invoices', [InvoiceController::class, 'store']);

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');

});

require __DIR__ . '/auth.php';