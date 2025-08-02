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
        Schema::create('detail_obat_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_masuk_id')->constrained('obat_masuks')->onDelete('cascade'); // Foreign key ke tabel obat_masuks
            $table->foreignId('data_obat_id')->constrained('data_obats')->onDelete('cascade'); // Foreign key ke tabel data_obats
            $table->string('no_batch')->nullable();
            $table->integer('jumlah_beli'); // Jumlah obat yang dibeli
            $table->decimal('harga_beli', 10, 2); // Harga beli obat
            $table->decimal('harga_jual', 10, 2)->nullable(); // Harga jual obat, bisa null
            $table->date('expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_obat_masuks');
    }
};