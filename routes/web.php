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
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Auth;


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

    Route::resource('users', UserController::class);

    // Batches 
    Route::resource('batches', BatchController::class);

    Route::resource('courses', CoursesController::class);

    // routes/web.php

    Route::resource('proffessors', ProffessorContoller::class);

    // routes/web.php
    Route::get('/get-batches/{courseId}', [StudentController::class, 'getBatches']);
    Route::get('/get-professors/{courseId}', [StudentController::class, 'getProfessors']);
    Route::get('/get-courseFee/{courseId}', [StudentController::class, 'getCourseFee']);


    Route::get('/professors', [ProffessorContoller::class, 'index'])->name('professors.index');
    
    Route::get('/student_fee_transactions', [StudentFeeTransactionController::class, 'index'])->name('student_fee_transactions.index');
    Route::get('/student_fee_transactions/create', [StudentFeeTransactionController::class, 'create'])->name('student_fee_transactions.create');
    Route::post('/student_fee_transactions/store', [StudentFeeTransactionController::class, 'store'])->name('student_fee_transactions.store');
    
    Route::resource('student_fee_transactions', StudentFeeTransactionController::class);
    Route::get('/student-course-fees', [StudentCourseFeeController::class, 'index'])->name('student_course_fees.index');
    Route::get('student_course_fees/{id}', [StudentCourseFeeController::class, 'show'])->name('student_course_fees.show');
    Route::get('student_fee_transactions/{id}/edit', [StudentFeeTransactionController::class, 'edit'])->name('student_fee_transactions.edit');
    Route::put('student_fee_transactions/{student_fee_transaction}', [StudentFeeTransactionController::class, 'update'])->name('student_fee_transactions.update');

    Route::get('/student-course-fees/calendar', [CalendarController::class, 'index'])->name('student_course_fees.calendar');

    Route::post('/invoices', [InvoiceController::class, 'store']);

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    Route::get('/invoices/pdf/{id}', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
    
    Route::get('/student-personal-invoices', [InvoiceController::class, 'studentInvoices'])
    ->middleware('role:Student')
    ->name('invoices.personal');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

});    
    
require __DIR__ . '/auth.php';