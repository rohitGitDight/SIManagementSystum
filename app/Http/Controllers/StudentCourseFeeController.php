<?php

namespace App\Http\Controllers;

use App\Models\StudentCourseFee;
use App\Models\StudentFeeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StudentCourseFeeController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('view student course fees')) {
            abort(403, 'Unauthorized action.');
        }

        $fees = StudentCourseFee::with(['user' => function ($query) {
            $query->where('is_active', 1);
        }, 'course'])->get()->filter(function ($fee) {
            return $fee->user !== null; // Remove records where user is null
        });

        return view('student_course_fees.index', compact('fees'));
    }


    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('view student course fees')) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve the fee record along with related user and course details
        $fee = StudentCourseFee::with('user', 'course')->findOrFail($id);

        return view('student_course_fees.show', compact('fee'));
    }

}


