<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFeeTransaction;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Course;
use App\Models\Model_has_role;
use App\Models\StudentCourseFee;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;

class StudentFeeTransactionController extends Controller {

    public function index() {
        $transactions = StudentFeeTransaction::with('student', 'course')->get();
        return view('student_fee_transactions.index', compact('transactions'));
    }

    public function create() {
        $studentIds = Model_has_role::where('role_id', 4)->pluck('model_id');
    
        $students = User::whereIn('id', $studentIds)->get();
    
        $studentImgs = UserDetail::whereIn('user_id', $studentIds)->get();

        $courses = Course::where('is_active', 1)->get();

        $nextDate = StudentCourseFee::get();
    
        return view('student_fee_transactions.create', compact('students', 'courses' , 'studentImgs' , 'nextDate'));
    }
    
    public function store(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'transaction_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|integer',
            'transaction_report' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB file
        
            // Conditional validation
            'transaction_id'   => 'nullable|required_without_all:cheque_number,cash_received_by',
            'cheque_number'    => 'nullable|required_without_all:transaction_id,cash_received_by',
            'cash_received_by' => 'nullable|required_without_all:transaction_id,cheque_number',

            'payment_done_date' => 'required|date', // Ensure it is a valid date
        ]);
        
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle transaction report file upload
        $filePath = null;
        if ($request->hasFile('transaction_report')) {
            $filePath = $request->file('transaction_report')->store('uploads', 'public');
        }
        
        // Create the new transaction record
        StudentFeeTransaction::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'transaction_type' => $request->transaction_type,
            'transaction_id' => $request->transaction_id,
            'cheque_number' => $request->cheque_number,
            'cash_received_by' => $request->cash_received_by,
            'transaction_report' => $filePath,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'payment_done_date' => $request->payment_done_date, // Added this line
        ]);
    
        // Update student_course_fees table
        $studentCourseFee = StudentCourseFee::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->first();
    
        if ($studentCourseFee) {
            $paymentDetails = json_decode($studentCourseFee->payment_details, true);
    
            // Check if payment_type exists in the payment_details array
            $index = $request->payment_type - 1;  // Assuming payment_type is 1-based and maps to index 0, 1, etc.
    
            if (isset($paymentDetails[$index])) {
                // Update the payment status of the specific entry based on payment_type
                $paymentDetails[$index]['payment'] = $paymentDetails[$index]['payment'] - $request->amount;
                if($paymentDetails[$index]['payment'] == 0){
                    $paymentDetails[$index]['payment_status'] = 1;
                }
                // Update the database record
                $studentCourseFee->update([
                    'payment_details' => json_encode($paymentDetails)
                ]);
            }

            // Calculate the remaining amount by summing the amounts of pending payment status elements
            $remainingAmount = 0;
            foreach ($paymentDetails as $paymentDetail) {
                $remainingAmount += $paymentDetail['payment'];
            }

            // Update remaining_amount in the database
            $studentCourseFee->update([
                'remaining_amount' => $remainingAmount
            ]);
        }

        $pendingAmount = $request->payment_amount - $request->amount;
        $data = [
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'payment_details' => [
                'transaction_type' => $request->transaction_type,
                'transaction_id' => $request->transaction_id,
                'cheque_number' => $request->cheque_number,
                'cash_received_by' => $request->cash_received_by,
                'transaction_report' => $filePath,
                'amount' => $request->amount,
                'payment_type' => $request->payment_type,
                'payment_date' => $request->payment_date,
                'pending_amount' => $pendingAmount,
                'next_payment_date' => $request->next_payment_date ?? '-',
                'next_payment_amount' => $request->next_payment_amount ?? '0',
                'remaining_amount' => $remainingAmount ?? '0',
                'payment_done_date' => $request->payment_done_date
            ],
            'payment_type' => $request->payment_type
        ];    
    
        $this->createInvoice($data);
    
        return redirect()->route('student_fee_transactions.index')->with('success', 'Fee transaction recorded successfully!');
    }

    public function edit($id)
    {
        // Get the student IDs who have the role of 'student' (role_id = 4)
        $studentIds = Model_has_role::where('role_id', 4)->pluck('model_id');

        // Fetch students and their details
        $students = User::whereIn('id', $studentIds)->get();
        $studentImgs = UserDetail::whereIn('user_id', $studentIds)->get();

        // Add image attribute to student objects
        foreach ($students as $student) {
            $student->image = optional($studentImgs->where('user_id', $student->id)->first())->image;
        }

        // Fetch active courses
        $courses = Course::where('is_active', 1)->get();

        // Fetch the specific fee transaction
        $transaction = StudentFeeTransaction::findOrFail($id);

        return view('student_fee_transactions.edit', compact('students', 'courses', 'transaction'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'transaction_type' => 'required|string',
            'transaction_id' => 'nullable|string',
            'cheque_number' => 'nullable|string',
            'cash_received_by' => 'nullable|string',
            'transaction_report' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'amount' => 'required|numeric|min:0',
            'payment_done_date' => 'required|date', // Ensure it is a valid date
        ]);

        // Find the transaction
        $transaction = StudentFeeTransaction::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('transaction_report')) {
            $file = $request->file('transaction_report');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('transaction_reports', $filename, 'public');

            // Delete old file if it exists
            if ($transaction->transaction_report) {
                Storage::disk('public')->delete('transaction_reports/' . $transaction->transaction_report);
            }

            $transaction->transaction_report = $filename;
        }

        // Update transaction details
        $transaction->transaction_type = $request->transaction_type;
        $transaction->transaction_id = $request->transaction_id;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->cash_received_by = $request->cash_received_by;
        $transaction->amount = $request->amount;
        $transaction->payment_done_date = $request->payment_done_date;

        // Save the changes
        $transaction->save();

        // Redirect with success message
        return redirect()->route('student_fee_transactions.index')->with('success', 'Transaction updated successfully!');
    }

    public function createInvoice_old($data){
        $paymentDetails = $data['payment_details'];
        
        // Ensure payment details is in proper JSON format
        $paymentDetailsJson = json_encode($paymentDetails);
        
        // Create the invoice
        $invoice = Invoice::create([
            'user_id' => $data['user_id'],
            'course_id' => $data['course_id'],
            'payment_details' => $paymentDetailsJson, // Store payment details as JSON
        ]);
    
        return response()->json($invoice, 201);
    }

    public function createInvoice($data){
        // Check if an invoice already exists for the given criteria
        $invoice = Invoice::where('user_id', $data['user_id'])
            ->where('course_id', $data['course_id'])
            ->where('payment_type', $data['payment_type'])
            ->first();

        if ($invoice) {
            // Decode the existing payment details JSON
            $existingDetails = json_decode($invoice->payment_details, true);

            // Ensure it's an array before appending
            if (!is_array($existingDetails)) {
                $existingDetails = [];
            }

            // Append the new payment detail
            $existingDetails[] = $data['payment_details'];

            // Update the invoice with the modified payment details
            $invoice->update([
                'payment_details' => json_encode($existingDetails),
            ]);

            return response()->json(['message' => 'Invoice updated successfully', 'invoice' => $invoice], 200);
        } else {
            // Create a new invoice if it does not exist
            $invoice = Invoice::create([
                'user_id' => $data['user_id'],
                'course_id' => $data['course_id'],
                'payment_details' => json_encode([$data['payment_details']]), // Store as an array
                'payment_type' => $data['payment_type'],
            ]);

            return response()->json(['message' => 'Invoice created successfully', 'invoice' => $invoice], 201);
        }
    }

    
}
