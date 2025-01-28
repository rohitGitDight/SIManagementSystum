<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/UserDetail.php
    public function course(){
        return $this->belongsTo(Course::class, 'course_id'); // Assuming 'course_id' is the foreign key
    }


}
