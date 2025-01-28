<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Foreign key for users
            $table->foreignId('course_id')->constrained('courses'); // Foreign key for courses
            $table->decimal('course_fee', 8, 2); // Course fee
            $table->decimal('first_payment', 8, 2)->nullable(); // First installment payment
            $table->decimal('second_payment', 8, 2)->nullable(); // Second installment payment
            $table->decimal('third_payment', 8, 2)->nullable(); // Third installment payment
            $table->decimal('fourth_payment', 8, 2)->nullable(); // Fourth installment payment
            $table->decimal('remaining_amount', 8, 2); // Remaining amount to be paid
            $table->date('first_payment_date')->nullable(); // Date for first payment
            $table->date('second_payment_date')->nullable(); // Date for second payment
            $table->date('third_payment_date')->nullable(); // Date for third payment
            $table->date('fourth_payment_date')->nullable(); // Date for fourth payment
            $table->date('course_start_date'); // Start date for the course (added)
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_fees');
    }
};
