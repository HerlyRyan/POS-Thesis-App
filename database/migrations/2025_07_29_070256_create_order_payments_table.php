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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->enum('role', ['sopir', 'buruh']); // untuk identifikasi
            $table->decimal('amount', 12, 2);            
            $table->date('paid_at')->nullable(); // null = belum dibayar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
