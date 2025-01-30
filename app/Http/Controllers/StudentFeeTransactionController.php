<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFeeTransaction;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Course;
use App\Models\Model_has_role;

class StudentFeeTransactionController extends Controller {

    public function index() {
        $transactions = StudentFeeTransaction::with('student', 'course')->get();
        return view('student_fee_transactions.index', compact('transactions'));
    }

    public function create() {
        $studentIds = Model_has_role::where('role_id', 4)->pluck('model_id');
    
        $students = User::whereIn('id', $studentIds)->get();
    
        $studentImgs = UserDetail::whereIn('user_id', $studentIds)->get();
    
        foreach ($studentImgs as $studentImg) {
            $students->image = $studentImg ? $studentImg->image : null; // Add image to the student object
        }

        $courses = Course::where('is_active', 1)->get();
    
        return view('student_fee_transactions.create', compact('students', 'courses'));
    }
    
    

    // public function create() {
    //     // Get student IDs from model_has_roles where role_id is 4 (assuming 4 is for students)
    //     $studentIds = Model_has_role::where('role_id', 4)->pluck('model_id');
    
    //     // Fetch only those users who are students
    //     $students = User::whereIn('id', $studentIds)->get();
    
    //     // Fetch all courses
    //     $courses = Course::where('is_active',1)->get();
    
    //     return view('student_fee_transactions.create', compact('students', 'courses'));
    // }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'transaction_type' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'transaction_report' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $filePath = null;
        if ($request->hasFile('transaction_report')) {
            $filePath = $request->file('transaction_report')->store('uploads', 'public');
        }

        StudentFeeTransaction::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'transaction_type' => $request->transaction_type,
            'transaction_id' => $request->transaction_id,
            'cheque_number' => $request->cheque_number,
            'cash_received_by' => $request->cash_received_by,
            'transaction_report' => $filePath,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date
        ]);

        return redirect()->route('student_fee_transactions.index')->with('success', 'Fee transaction recorded successfully!');
    }

}
