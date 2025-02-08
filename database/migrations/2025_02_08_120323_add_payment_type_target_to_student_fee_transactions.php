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
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->string('payment_type_target')->after('payment_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->dropColumn('payment_type_target');
        });
    }
};
