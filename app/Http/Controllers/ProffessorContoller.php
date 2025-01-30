<?php

namespace App\Http\Controllers;

use App\Models\Model_has_role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use App\Models\Course;

class ProffessorContoller extends Controller
{
    public function index(Request $request): View
    {
        // Fetch only active users and paginate
        $data = Model_has_role::whereIn('role_id', [2, 3])->orderBy('model_id', 'desc')->with("userName", "userDetail")->paginate(5);

        return view('proffessors.index', compact('data'))
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
        return view('proffessors.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): RedirectResponse
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|same:confirm-password|min:8',
            'dob' => 'required|date',
            'married' => 'required|boolean',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number',
            'role' => 'required',
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

        $roleData = [
            'role_id' => $request->role,
            'model_type' => "App\\Models\\User",
            'model_id' => $user->id,
        ];
        // Assign role to the user (if using Spatie Laravel Permission)
        \DB::table('Model_has_roles')->insert($roleData);

        // Insert data into user_details table
        $userDetailsData = $request->only([
            'dob',
            'married',
            'contact',
            'address',
            'city',
            'state',
            'course',
            'aadhaar_card_number'
        ]);
        $userDetailsData['user_id'] = $user->id;

        // Use DB facade to insert data
        \DB::table('user_details')->insert($userDetailsData);

        // Redirect with success message
        return redirect()->route('proffessors.index')
            ->with('success', 'Proffessor and details created successfully');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        // Retrieve the user along with their details using Eloquent's `with` method.
        $user = User::with('details')->findOrFail($id);

        return view('proffessors.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id): View
    {
        // Retrieve the user and their details using the relationship
        $user = User::with('details')->findOrFail($id);
        $courses = Course::all();
        return view('proffessors.edit', compact('user' , 'courses'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|same:confirm-password|min:8',
            'dob' => 'required|date',
            'married' => 'required|boolean',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number',
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
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'course' => $request->course,
                'student_batch' => $request->student_batch,
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
    public function destroy($id): RedirectResponse
    {
        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            // Update the user's email and set 'is_active' to 0 instead of deleting
            $user->email = $user->email . "-" . $id;
            $user->is_active = 0;
            $user->save();

            // Delete the associated records from model_has_roles where model_id equals the user's id
            Model_has_role::where('model_id', $id)->delete();
        }

        // Redirect with success message
        return redirect()->route('professors.index')
            ->with('success', 'User deleted successfully');
    }

}