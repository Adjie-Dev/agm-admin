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
            Schema::create('aturan_uposatha', function (Blueprint $table) {
            $table->id();
            $table->enum('fase_bulan', ['bulan_baru', 'paruh_pertama', 'purnama', 'paruh_akhir']);
            $table->string('nama_acara');
            $table->text('deskripsi')->nullable();
            $table->string('warna')->default('#06b6d4');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};