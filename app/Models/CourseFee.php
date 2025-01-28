<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'course_id', 
        'course_fee', 
        'first_payment', 
        'second_payment', 
        'third_payment', 
        'fourth_payment', 
        'remaining_amount', 
        'first_payment_date', 
        'second_payment_date', 
        'third_payment_date', 
        'fourth_payment_date',
        'course_start_date'
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
