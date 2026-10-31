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

        $table->foreignId('user_id')
              ->constrained('users')
              ->restrictOnDelete();

        $table->string('customer_name', 150);
        $table->string('customer_phone', 25);
        $table->text('customer_address')->nullable();

        $table->date('deadline')->nullable();

        $table->enum('status', [
            'baru',
            'dikonfirmasi',
            'diproses',
            'selesai',
            'dibatalkan',
        ])->default('baru');

        $table->text('notes')->nullable();

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
