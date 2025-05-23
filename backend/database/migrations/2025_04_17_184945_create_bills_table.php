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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('amount', 10, 2);
            $table->foreignId('category_id')->constrained('bills_categories')->onDelete('cascade');
            $table->enum('frequency', ['one-time', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly'])->default('monthly');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('due_date');
            $table->date('last_payment')->nullable();
            $table->boolean('is_recurred')->default(false);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
