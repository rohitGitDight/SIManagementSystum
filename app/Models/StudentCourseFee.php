<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'course_fee', 'payment_details', 'remaining_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}