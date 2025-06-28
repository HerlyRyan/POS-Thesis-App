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
        Schema::create('finance_reports', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']); // pemasukan atau pengeluaran
            $table->string('category'); // misal: 'Penjualan', 'Gaji', 'Beli Bahan'
            $table->string('source');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_reports');
    }
};
