<?php

namespace App\Http\Controllers;

use App\Models\StudentCourseFee;
use Illuminate\Http\Request;

class StudentCourseFeeController extends Controller
{
    public function index()
    {
        $fees = StudentCourseFee::with('user', 'course')->get();
        return view('student_course_fees.index', compact('fees'));
    }
}
