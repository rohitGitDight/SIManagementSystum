<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('course')->get();
        return view('batches.index', compact('batches'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('batches.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i', // Validate start time
            'end_time' => 'required|date_format:H:i|after:start_time', // Validate end time
            'course_id' => 'required|exists:courses,id',
            'batch_start_date' => 'required|after_or_equal:today', // Ensure it's a valid date
        ]);

        Batch::create($request->only(['batch_name', 'start_time', 'end_time', 'course_id' , 'batch_start_date']));
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $courses = Course::all();
        return view('batches.edit', compact('batch', 'courses'));
    }
    
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'batch_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'course_id' => 'required|exists:courses,id',
            'batch_start_date' => 'required|date',
        ]);

        $batch->update($request->only(['batch_name', 'start_time', 'end_time', 'course_id', 'batch_start_date']));

        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }


    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }

    public function show($id)
    {
        $batch = Batch::with('course')->findOrFail($id);
        return view('batches.show', compact('batch'));
    }
}