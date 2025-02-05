<?php

namespace App\Http\Controllers;

use App\Models\StudentCourseFee;
use App\Models\StudentFeeTransaction;
use Illuminate\Http\Request;

class StudentCourseFeeController extends Controller
{
    public function index()
    {
        $fees = StudentCourseFee::with('user', 'course')->get();
        return view('student_course_fees.index', compact('fees'));
    }

    public function show($id)
    {
        // Retrieve the fee record along with related user and course details
        $fee = StudentCourseFee::with('user', 'course')->findOrFail($id);

        return view('student_course_fees.show', compact('fee'));
    }

}


