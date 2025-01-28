<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_fee_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('fee_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');  // This will reference the user table's id
            $table->enum('transaction_type', ['Cheque', 'Cash', 'Paytm', 'Google Pay', 'RTNS', 'Bank Transfer']);
            $table->string('transaction_id')->nullable();  // For Paytm, Google Pay, etc.
            $table->string('cheque_number')->nullable();   // For cheque transactions
            $table->string('cash_received_by')->nullable(); // For cash transactions
            $table->string('transaction_report')->nullable();  // File path for uploaded transaction proof
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->timestamps();

            // Create foreign key reference to the users table (student role)
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_transactions');
    }
}