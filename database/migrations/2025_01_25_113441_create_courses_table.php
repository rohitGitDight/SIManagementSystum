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
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name_of_course'); // Name of the course
            $table->string('duration'); // Duration (e.g., "6 months")
            $table->decimal('fee', 10, 2); // Fee with precision and scale
            $table->string('professor'); // Professor's name
            $table->integer('batches'); // Number of batches
            $table->boolean('is_active')->default(true); // Boolean for active status, default to true
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
