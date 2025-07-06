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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');            
            $table->foreignId('driver_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('truck_id')->nullable()->constrained()->onDelete('set null');
            $table->date('shipping_date')->nullable();
            $table->enum('status', ['draft', 'persiapan', 'pengiriman', 'selesai'])->default('draft'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
