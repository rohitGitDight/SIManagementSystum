<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Model_has_role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Batch; // Assuming you have a Batch model
use Carbon\Carbon;
use App\Models\StudentCourseFee;


class StudentController extends Controller
{

    //
    public function index(Request $request): View{
        // Fetch only active users and paginate
        $data1 = Model_has_role::where('role_id', 4)->orderBy('model_id', 'desc')->pluck('model_id');
        $data = User::whereIn("id", $data1)->where('is_active', 1)->latest()->paginate(5);

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
            'image' => 'nullable|file|mimes:jpeg,png,pdf,jpg',
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
            'student_batch' => 'nullable|integer|max:255',
            'batch_professor' => 'nullable|string|max:255',
            'fee' => 'nullable|numeric',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number',
            'course_start_date' => 'nullable|date'
        ]);


        // Handle file upload if exists
        $new_name = null;
        if ($request->hasFile('image')) {
            // Store the uploaded file in the public disk, under 'transaction_reports' folder
            $new_name = $request->file('image')->store('transaction_reports', 'public');
        }

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
            'aadhaar_card_number',
            'course_start_date'
        ]);
        $userDetailsData['user_id'] = $user->id;
        $userDetailsData['image'] = $new_name;
        
        // Use DB facade to insert data
        \DB::table('user_details')->insert($userDetailsData);

        // Call getInstallmentDates() after inserting user details
        $this->getInstallmentDates($user);

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
        $userDetail = UserDetail::where('user_id', $id)->firstOrFail();

        $courseId = $userDetail->course;
        $studentBatch = $userDetail->student_batch;
        
        // Fetch courses from the 'courses' table
        $slectedCourse = Course::where('id',$courseId)->get();

        $courseBatch = Batch::where('id' , $studentBatch)->get();

        $proffesors = Model_has_role::whereIn('role_id', [3])->where('model_id' , $userDetail->batch_professor )->with("userName", "userDetail")->get();

        return view('students.show', compact('user', 'slectedCourse' , 'courseBatch' , 'proffesors'));
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
        $userDetail = UserDetail::where('user_id', $id)->firstOrFail();

        $courseId = $userDetail->course;
        // Fetch courses from the 'courses' table
        $courses = Course::all();

        $courseBatch = Batch::where('course_id',$courseId)->get();

        $proffesors = Model_has_role::whereIn('role_id', [3])->with("userName", "userDetail")->get();

        // Pass the user and courses to the view
        return view('students.edit', compact('user', 'courses','courseBatch' , 'proffesors'));
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
            'student_batch' => 'nullable|integer|max:255',
            'batch_professor' => 'nullable|string|max:255',
            'fee' => 'nullable|numeric',
            'aadhaar_card_number' => 'nullable|string|max:16|unique:user_details,aadhaar_card_number,' . $id . ',user_id',
            'course_start_date' => 'nullable|date'
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
                'course_start_date' => $request->course_start_date,
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
        return redirect()->route('students.index')
            ->with('success', 'User deleted successfully');
    }


    public function getBatches($courseId)
    {
        // Fetch batches for the selected course
        $batches = Batch::where('course_id', $courseId)->get();

        // Return batches as JSON
        return response()->json(['batches' => $batches]);
    }

    public function getProfessors($courseId)
    {
        // Fetch professors for the given course
        $data1 = Model_has_role::where('role_id', 3)->orderBy('model_id', 'desc')->pluck('model_id');
        $professors = UserDetail::whereIn("user_id", $data1)->where('course',$courseId)->with('userName')->get();  // Example query
        return response()->json(['professors' => $professors]);

    }

    public function getCourseFee($courseId)
    {
        $courseFee = Course::where('id' , $courseId)->get();
        return response()->json(['courseFee' => $courseFee]);

    }
    

    public function getInstallmentDates($userId)
    {
        $user_id = $userId->id;
        // Get user details
        $userDetail = UserDetail::where('user_id', $user_id)->firstOrFail();
        
        // Get course details
        $course = Course::where('id', $userDetail->course)->first();

        if (!$course || !$userDetail->course_start_date || !$userDetail->fee) {
           
            return ['error' => 'Course, course start date, or fee not found'];
        }
        
        // Convert to Carbon instance
        $startDate = Carbon::parse($userDetail->course_start_date);
        
        // Installment logic
        $duration = $course->duration; // e.g., 60 days
        $installmentCycle = $course->installment_cycle; // e.g., 3
        $paymentAmount = $userDetail->fee / $installmentCycle; // e.g., 30000 / 3 = 10000

        $intervalDays = $duration / $installmentCycle; // 60 / 3 = 20 days
        
        // Generate installment details
        $installments = [];
        for ($i = 0; $i < $installmentCycle; $i++) {
            $installments[] = [
                'payment' => round($paymentAmount, 2),
                'payment_date' => $startDate->copy()->addDays($intervalDays * $i)->format('Y-m-d'),
                'payment_status' => 0 // Default status
            ];
        }
        $courseFee = $userDetail->fee;
        // Save to StudentCourseFee model
        StudentCourseFee::Create([
            'user_id' => $user_id, // Find by user_id
            'course_id' => $course->id,
            'course_fee' => $courseFee , 
            'remaining_amount' => $courseFee , 
            'payment_details' => json_encode($installments)] // Save as JSON
        );

        return ['message' => 'Payment details saved successfully', 'data' => $installments];
    }

}