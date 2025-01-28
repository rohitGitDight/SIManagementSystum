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
            $table->boolean('first_payment_status')->default(0)->after('fourth_payment_date')->comment('0: Pending, 1: Done');
            $table->boolean('second_payment_status')->default(0)->after('first_payment_status')->comment('0: Pending, 1: Done');
            $table->boolean('third_payment_status')->default(0)->after('second_payment_status')->comment('0: Pending, 1: Done');
            $table->boolean('fourth_payment_status')->default(0)->after('third_payment_status')->comment('0: Pending, 1: Done');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_fees', function (Blueprint $table) {
            $table->dropColumn(['first_payment_status', 'second_payment_status', 'third_payment_status', 'fourth_payment_status']);
        });
    }
};
