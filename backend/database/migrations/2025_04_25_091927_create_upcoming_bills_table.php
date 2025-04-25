<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpcomingBillsTable extends Migration
{
    public function up()
    {
        Schema::create('upcoming_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_bill_id')->constrained('bills')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['unpaid', 'pending','paid'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('upcoming_bills');
    }
}