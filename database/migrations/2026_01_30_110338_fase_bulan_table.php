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
            Schema::create('fase_bulan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->enum('fase', ['bulan_baru', 'paruh_pertama', 'purnama', 'paruh_akhir']);
            $table->decimal('iluminasi', 5, 2)->comment('Persentase 0-100');
            $table->integer('hari_lunar')->nullable()->comment('Hari dalam bulan lunar 1-30');
            $table->timestamps();
            $table->index('tanggal');
            $table->index('fase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fase_bulan');
    }
};