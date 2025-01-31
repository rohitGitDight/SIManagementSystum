<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Model_has_role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class CoursesController extends Controller
{
    public function index(Request $request)
    {
        $data = Course::where('is_active', 1)->latest()->paginate(5);

        return view('courses.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data1 = Model_has_role::where('role_id', 3)->orderBy('model_id', 'desc')->pluck('model_id');
        $professors = User::whereIn("id", $data1)->where('is_active', 1)->latest()->paginate(5);
        return view('courses.create', compact('professors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_of_course' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'professor' => 'required|string|max:255',
            'batches' => 'required|integer|min:1',
            'installment_cycle' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $courseData = $request->only(['name_of_course', 'duration', 'fee', 'professor', 'batches','installment_cycle']);
        Course::create($courseData);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $course = Course::findOrFail($id);
        $data1 = Model_has_role::where('role_id', 3)->orderBy('model_id', 'desc')->pluck('model_id');
        $professor = User::where('is_active', 1)->where('id' , $course->professor)->first();

        return view('courses.show', compact('course' , 'professor'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id): View
    {
        $course = Course::findOrFail($id);

        return view('courses.edit', compact('course'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate input
        $request->validate([
            'name_of_course' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
            'professor' => 'required|string|max:255',
            'batches' => 'required|integer|min:1',
            'installment_cycle' => 'required|integer' // Accepts any string input
        ]);

        $course = Course::findOrFail($id);

        $course->update([
            'name_of_course' => $request->name_of_course,
            'duration' => $request->duration,
            'fee' => $request->fee,
            'professor' => $request->professor,
            'batches' => $request->batches,
            'installment_cycle' => $request->installment_cycle
        ]);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = Course::find($id);

        $whereCourseID = array('course_id' => $id);

        $deletQuery = \DB::table('batches');

        foreach($whereCourseID as $field => $value) {
            $deletQuery->where($field, $value);
        }

        if ($courses) {
            $courses->is_active = 0;
            $courses->save();
            $deletQuery->delete();
        }
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
