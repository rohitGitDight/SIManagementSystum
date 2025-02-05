<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourseFee;

class CalendarController extends Controller
{
    // public function index()
    // {
    //     // Fetch payment details from the database
    //     $fees = StudentCourseFee::select('payment_details')->get();
    //     // Extract payment dates
    //     $paymentDates = [];
        
    //     foreach ($fees as $fee) {
    //         $details = json_decode($fee->payment_details, true); // Decode JSON
            
    //         foreach ($details as $payment) {
    //             if (!empty($payment['payment_date'])) {
    //                 $paymentDates[] = [
    //                     'title' => 'Payment Due',
    //                     'start' => $payment['payment_date'],
    //                     'color' => 'red' // Highlight color for payments
    //                 ];
    //             }
    //         }
    //     }

    //     return view('calendar', compact('paymentDates'));
    // }

    public function index_old(){
        // Fetch payment details from the database
        $fees = StudentCourseFee::select('payment_details', 'user_id', 'course_id')->get();
        $paymentDates = [];
    
        foreach ($fees as $fee) {
            $details = json_decode($fee->payment_details, true); // Decode JSON
    
            // Fetch user name
            $user = User::find($fee->user_id);
            $userName = $user ? $user->name : 'Unknown User';
    
            // Fetch course name
            $course = Course::find($fee->course_id);
            $courseName = $course ? $course->name_of_course : 'Unknown Course';
    
            foreach ($details as $payment) {
                if (!empty($payment['payment_date'])) {
                    $paymentDates[] = [
                        'title' => "{$userName} - {$courseName} Pending",
                        'start' => $payment['payment_date'],
                        'color' => 'red' // Highlight color for payments
                    ];
                }
            }
        }
    
        return view('calendar', compact('paymentDates'));
    }

    public function index()
    {
        // Fetch payment details from the database
        $fees = StudentCourseFee::select('payment_details', 'user_id', 'course_id', 'id')->get();

        $paymentDates = [];

        foreach ($fees as $fee) {
            $details = json_decode($fee->payment_details, true); // Decode JSON

            // Fetch user name
            $user = User::find($fee->user_id);
            $userName = $user ? $user->name : 'Unknown User';

            // Fetch course name
            $course = Course::find($fee->course_id);
            $courseName = $course ? $course->name_of_course : 'Unknown Course';

            foreach ($details as $payment) {
                if (!empty($payment['payment_date'])) {
                    $paymentDates[] = [
                        'title' => "{$userName} - {$courseName} Pending",
                        'start' => $payment['payment_date'],
                        'color' => 'red', // Highlight color for payments
                        'url' => route('student_course_fees.show', ['id' => $fee->id]) // The URL for the event
                    ];
                }
            }
        }

        return view('calendar', compact('paymentDates'));
    }

    

    

}

