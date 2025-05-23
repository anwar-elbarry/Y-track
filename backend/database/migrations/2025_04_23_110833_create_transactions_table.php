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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('income_id')->nullable()->default(null)->constrained('incomes')->onDelete('cascade');
            $table->foreignId('goal_id')->nullable()->default(null)->constrained('goals')->onDelete('cascade');
            $table->foreignId('expense_id')->nullable()->default(null)->constrained('expenses')->onDelete('cascade');
            $table->foreignId('bill_id')->nullable()->default(null)->constrained('bills')->onDelete('cascade');
            $table->enum('type', [
                'income', 
                'expense', 
                'bill',
                'goal',
            ]);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
