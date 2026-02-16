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
        Schema::create('puja_sore', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan')->unique()->comment('Urutan section 1-17');
            $table->string('judul', 150);
            $table->string('durasi', 20)->nullable()->comment('Otomatis dari audio: MM:SS');
            $table->text('deskripsi')->nullable();
            $table->string('audio_path')->nullable()->comment('Path file: audio/pujasore/nama.mp3');
            $table->string('audio_nama_asli')->nullable();
            $table->string('audio_mime')->nullable();
            $table->unsignedInteger('audio_ukuran_kb')->nullable();
            $table->longText('teks_pali')->nullable();
            $table->longText('terjemahan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puja_sore');
    }
};
