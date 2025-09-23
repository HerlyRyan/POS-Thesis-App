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
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->string('lender_name'); // contoh: Bank Mandiri
            $table->string('description')->nullable(); // keterangan utang
            $table->decimal('total_amount', 15, 2); // jumlah total utang
            $table->decimal('installment_amount', 15, 2)->nullable(); // cicilan per bulan
            $table->decimal('remaining_amount', 15, 2);
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->date('due_date')->nullable(); // jatuh tempo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
