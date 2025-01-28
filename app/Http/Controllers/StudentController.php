<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Course;

class StudentController extends Controller
{

    //
    public function index(Request $request): View{
        // Fetch only active users and paginate
        $data = User::where('is_active', 1)->latest()->paginate(5);

        return view('students.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        // Fetch courses from the 'courses' table
        $courses = Course::all();

        // Pass the courses to the view
        return view('students.create', compact('courses'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|same:confirm-password|min:8',
            'dob' => 'required|date',
            'married' => 'required|boolean',
            'contact' => 'nullable|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_mobile' => 'nullable|string|max:15',
            'mother_mobile' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'student_batch' => 'nullable|string|max:255',
            'batch_professor' => 'nullable|string|max:255',
            'fee' => 'nullable|numeric',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        // Assign role to the user (if using Spatie Laravel Permission)
        $user->assignRole('Student'); // Ensure 'Student' role exists

        // Insert data into user_details table
        $userDetailsData = $request->only([
            'dob',
            'married',
            'contact',
            'father_name',
            'mother_name',
            'father_mobile',
            'mother_mobile',
            'address',
            'city',
            'state',
            'course',
            'student_batch',
            'batch_professor',
            'fee',
            'aadhaar_card_number'
        ]);
        $userDetailsData['user_id'] = $user->id;

        // Use DB facade to insert data
        \DB::table('user_details')->insert($userDetailsData);

        // Redirect with success message
        return redirect()->route('students.index')
            ->with('success', 'User and details created successfully');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View{
        // Retrieve the user along with their details using Eloquent's `with` method.
        $user = User::with('details')->findOrFail($id);

        return view('students.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Fetch courses from the 'courses' table
        $courses = Course::all();

        // Pass the user and courses to the view
        return view('students.edit', compact('user', 'courses'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id){
        // Validate input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'dob' => 'required|date',
            'married' => 'required|boolean',
            'contact' => 'nullable|string|max:15',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_mobile' => 'nullable|string|max:15',
            'mother_mobile' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'student_batch' => 'nullable|string|max:255',
            'batch_professor' => 'nullable|string|max:255',
            'fee' => 'nullable|numeric',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number,' . $id . ',user_id',
        ]);

        // Update the users table
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Update the user_details table
        \DB::table('user_details')
            ->where('user_id', $id)
            ->update([
                'dob' => $request->dob,
                'married' => $request->married,
                'contact' => $request->contact,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'father_mobile' => $request->father_mobile,
                'mother_mobile' => $request->mother_mobile,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'course' => $request->course,
                'student_batch' => $request->student_batch,
                'batch_professor' => $request->batch_professor,
                'fee' => $request->fee,
                'aadhaar_card_number' => $request->aadhaar_card_number,
                'updated_at' => now(),
            ]);

        return redirect()->route('students.index')
            ->with('success', 'User and details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->email = $user->email."-".$id;
            $user->is_active = 0;
            $user->save();
        }
        return redirect()->route('students.index')
            ->with('success', 'User deleted successfully');
    }
}