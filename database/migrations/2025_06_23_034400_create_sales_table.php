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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // kasir
            $table->decimal('total_price', 12, 2);         
            $table->enum('payment_method', ['cash', 'transfer', 'cod'])->default('cash');
            $table->string('snap_url')->nullable();
            $table->enum('payment_status', ['dibayar', 'belum dibayar', 'cicil', 'cancelled'])->default('belum dibayar');
            $table->dateTime('transaction_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
