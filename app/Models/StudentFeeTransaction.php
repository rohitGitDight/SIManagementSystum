<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeTransaction extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'transaction_type',
        'transaction_id',
        'cheque_number',
        'cash_received_by',
        'transaction_report',
        'amount',
        'payment_type'
    ];

    public function student() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
