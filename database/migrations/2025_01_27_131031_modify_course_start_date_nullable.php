<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('course_fees', function (Blueprint $table) {
            $table->date('course_start_date')->nullable()->change(); // Make it nullable
        });
    }

    public function down()
    {
        Schema::table('course_fees', function (Blueprint $table) {
            $table->date('course_start_date')->nullable(false)->change(); // Revert back if needed
        });
    }

};
