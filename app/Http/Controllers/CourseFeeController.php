<?php

namespace App\Http\Controllers;

use App\Models\CourseFee;
use App\Models\UserDetail;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseFeeController extends Controller
{
    public function index()
    {
        // Get all course fees with the associated course details
        $courseFees = CourseFee::with('course')->get();  // Using 'with' to eager load the related course

        return view('course_fees.index', compact('courseFees'));
    }


    public function create()
    {
        $users = User::all();
        $courses = Course::all();
        return view('course_fees.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'course_fee' => 'required|numeric',
            'course_start_date' => 'required|date', // Validate the start date
            'course_duration' => 'required|integer',
        ]);

        $course_fee = $validated['course_fee'];
        $course_start_date = Carbon::parse($validated['course_start_date']);

        $course_duration = $validated['course_duration'];

        $installment = $course_fee / 4;
        $interval = $course_duration / 4;

        // Calculate the payment dates based on course start date
        $first_payment_date = $course_start_date->copy()->addDays($interval * 0);
        $second_payment_date = $course_start_date->copy()->addDays($interval * 1);
        $third_payment_date = $course_start_date->copy()->addDays($interval * 2);
        $fourth_payment_date = $course_start_date->copy()->addDays($interval * 3);

        // Insert the course fee record into the database
        CourseFee::create([
            'user_id' => $validated['user_id'],
            'course_id' => $validated['course_id'],
            'course_fee' => $course_fee,
            'first_payment' => $installment,
            'second_payment' => $installment,
            'third_payment' => $installment,
            'fourth_payment' => $installment,
            'remaining_amount' => $course_fee,
            'first_payment_date' => $first_payment_date,
            'second_payment_date' => $second_payment_date,
            'third_payment_date' => $third_payment_date,
            'fourth_payment_date' => $fourth_payment_date,
            'course_start_date' => $course_start_date, // Insert course_start_date
        ]);

        return redirect()->route('course_fees.index');
    }


    public function edit($id)
    {
        // Fetch the course fee details
        $courseFee = CourseFee::findOrFail($id);

        // Fetch all users to display in the dropdown
        $users = User::all();

        // Pass both the course fee and users to the view
        return view('course_fees.edit', compact('courseFee', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validate the input fields
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Validate user_id as an existing user
            'course_id' => 'required|exists:courses,id', // Validate course_id as an existing course
            'course_fee' => 'required|numeric|min:0', // Validate course_fee as a required numeric field
            'first_payment' => 'nullable|numeric',
            'second_payment' => 'nullable|numeric',
            'third_payment' => 'nullable|numeric',
            'fourth_payment' => 'nullable|numeric',
            'first_payment_date' => 'nullable|date',
            'second_payment_date' => 'nullable|date',
            'third_payment_date' => 'nullable|date',
            'fourth_payment_date' => 'nullable|date',
        ]);
    
        // Find the CourseFee record
        $courseFee = CourseFee::findOrFail($id);
    
        // Update the user and course details
        $courseFee->user_id = $validated['user_id'];
        $courseFee->course_id = $validated['course_id'];
        $courseFee->course_fee = $validated['course_fee'];
    
        // Update the course fee and payment details
        $courseFee->first_payment = $validated['first_payment'] ?? $courseFee->first_payment;
        $courseFee->second_payment = $validated['second_payment'] ?? $courseFee->second_payment;
        $courseFee->third_payment = $validated['third_payment'] ?? $courseFee->third_payment;
        $courseFee->fourth_payment = $validated['fourth_payment'] ?? $courseFee->fourth_payment;
    
        $courseFee->first_payment_date = $validated['first_payment_date'] ?? $courseFee->first_payment_date;
        $courseFee->second_payment_date = $validated['second_payment_date'] ?? $courseFee->second_payment_date;
        $courseFee->third_payment_date = $validated['third_payment_date'] ?? $courseFee->third_payment_date;
        $courseFee->fourth_payment_date = $validated['fourth_payment_date'] ?? $courseFee->fourth_payment_date;
    
        // Calculate the total paid amount
        $totalPaid = ($courseFee->first_payment ?? 0) + ($courseFee->second_payment ?? 0) +
                     ($courseFee->third_payment ?? 0) + ($courseFee->fourth_payment ?? 0);
    
        // Update the remaining amount and course fee
        $courseFee->remaining_amount = $totalPaid;
    
        // Save the updated CourseFee record
        $courseFee->save();
    
        // Redirect back to the course fees index page with a success message
        return redirect()->route('course_fees.index')->with('success', 'Course fee updated successfully.');
    }

    public function getCourseDetails($studentId)
    {
        // Retrieve the user detail record by student ID
        $userDetail = UserDetail::where('user_id', $studentId)->first();
        if ($userDetail) {
            // Get the course_id from the user_detail record
            $courseId = $userDetail->course;
            // Retrieve the course details from the courses table using the course_id
            $course = Course::find($courseId);

            if ($course) {
                return response()->json([
                    'course_name' => $course->name_of_course,  // Adjust column name if necessary
                    'course_id' => $courseId,
                    'course_duration' => $course->duration,    // Adjust column name if necessary
                    'course_fee' => $course->fee    // Adjust column name if necessary
                ]);
            }

            // Return error if the course is not found
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Return error if user details are not found
        return response()->json(['error' => 'User details not found'], 404);
    }

    public function destroy($id)
    {
        // Find the course fee record by its ID
        $courseFee = CourseFee::findOrFail($id);

        // Delete the course fee record
        $courseFee->delete();

        // Redirect back to the course fees index page with a success message
        return redirect()->route('course_fees.index')
                        ->with('success', 'Course fee deleted successfully.');
    }


}