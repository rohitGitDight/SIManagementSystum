<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('student_fee_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Student from users table
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('transaction_type', ['Cash', 'Cheque', 'Paytm', 'Google Pay', 'RTGS', 'Bank Transfer']);
            $table->string('transaction_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cash_received_by')->nullable();
            $table->string('transaction_report')->nullable();
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('student_fee_transactions');
    }
};
