<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // app/Http/Controllers/InvoiceController.php
    public function index()
    {
        // Eager load the user and course relationships
        $invoices = Invoice::with(['user', 'course'])->get();
        
        // Pass invoices to the view
        return view('invoices.index', compact('invoices'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Invoice $invoice)
    {
        // Eager load user and course relationships
        $invoice->load('user', 'course');

        // Return the invoice with related user and course data in JSON format
        return response()->json([
            'invoice' => $invoice,
            'user_name' => $invoice->user->name,   // Add user's name to the response
            'course_name' => $invoice->course->name_of_course // Add course's name to the response
        ]);
    }


}
