<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_of_course',
        'duration',
        'fee',
        'professor',
        'batches',
        'installment_cycle'
    ];

    public function courseFees()
    {
        return $this->hasMany(CourseFee::class, 'course_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}