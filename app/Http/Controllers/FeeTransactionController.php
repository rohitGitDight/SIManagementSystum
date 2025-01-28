<?php

namespace App\Http\Controllers;

use App\Models\FeeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeeTransactionController extends Controller
{
    public function create()
    {
        return view('fee_transactions.create');
    }

    public function index()
    {
        // Fetch all fee transactions for the logged-in student
        $feeTransactions = FeeTransaction::where('student_id', auth()->user()->id)->get();

        return view('fee_transactions.index', compact('feeTransactions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|string',
            'transaction_id' => 'nullable|string|max:255',
            'cheque_number' => 'nullable|string|max:255',
            'cash_received_by' => 'nullable|string|max:255',
            'transaction_report' => 'nullable|file|mimes:jpeg,png,pdf,jpg',
            'amount' => 'required|numeric|min:0|max:9999999999.99', // Example: max 10 digits
            'payment_date' => 'required|date',
        ]);

        // Handle file upload if exists
        $transaction_report_path = null;
        if ($request->hasFile('transaction_report')) {
            // Store the uploaded file in the public disk, under 'transaction_reports' folder
            $transaction_report_path = $request->file('transaction_report')->store('transaction_reports', 'public');
        }

        // Store the transaction record in the database
        FeeTransaction::create([
            'student_id' => auth()->user()->id,  // Assuming the student is logged in
            'transaction_type' => $request->transaction_type,
            'transaction_id' => $request->transaction_id,
            'cheque_number' => $request->cheque_number,
            'cash_received_by' => $request->cash_received_by,
            'transaction_report' => $transaction_report_path, // Use the correct variable name
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('fee_transactions.create')->with('success', 'Transaction added successfully.');
    }


    public function destroy($id)
    {
        $transaction = FeeTransaction::findOrFail($id); // Find the transaction or fail if not found
        
        $transaction->delete(); // Delete the transaction
        
        return redirect()->route('fee_transactions.index')->with('success', 'Fee transaction deleted successfully.');
    }

    public function show($id)
    {
        $transaction = FeeTransaction::findOrFail($id); // Retrieve the transaction or fail if not found
        return view('fee_transactions.show', compact('transaction'));
    }
}

