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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign Key to users table
            $table->date('dob')->nullable();
            $table->boolean('married')->default(false); // Boolean for married status
            $table->string('contact', 15)->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_mobile', 15)->nullable();
            $table->string('mother_mobile', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('course')->nullable();
            $table->string('student_batch')->nullable();
            $table->string('batch_professor')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->string('aadhaar_card_number', 16)->unique()->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
