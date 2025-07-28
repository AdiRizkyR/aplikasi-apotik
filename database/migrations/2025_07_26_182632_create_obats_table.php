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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_obat_id')->constrained('data_obats')->onDelete('cascade'); // Foreign key ke tabel data_obats
            $table->foreignId('obat_masuk_id')->constrained('obat_masuks')->onDelete('cascade'); // Foreign key ke tabel obat_masuks
            $table->integer('stok'); // Jumlah stok obat
            $table->decimal('harga', 10, 2); // Harga jual obat
            $table->date('expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
