<?php

// app/Models/FeeTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FeeTransaction extends Model
{
    use HasFactory;

    protected $casts = [
        'payment_date' => 'datetime', // Cast payment_date to Carbon instance
    ];

    protected $fillable = [
        'student_id',
        'transaction_type',
        'transaction_id',
        'cheque_number',
        'cash_received_by',
        'transaction_report',
        'amount',
        'payment_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}