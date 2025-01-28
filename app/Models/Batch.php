<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;

    // Specify the attributes that are mass assignable
    protected $fillable = ['batch_name', 'start_time', 'end_time', 'course_id'];

    /**
     * Relationship: A batch belongs to a course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
