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
        Schema::create('acara_buddhist', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_acara', [
                'uposatha',
                'waisak',
                'magha_puja',
                'asalha_puja',
                'kathina',
                'vassa_mulai',
                'vassa_selesai',
                'pavarana',
                'custom'
            ]);
            $table->string('nama'); // Nama acara
            $table->text('deskripsi')->nullable();
            $table->date('tanggal')->nullable()->comment('Null jika otomatis dari fase bulan');
            $table->foreignId('fase_bulan_id')->nullable()->constrained('fase_bulan')->onDelete('cascade');
            $table->boolean('berulang')->default(false)->comment('Apakah berulang tiap tahun');
            $table->string('warna')->default('#6366f1')->comment('Warna highlight di kalender');
            $table->boolean('aktif')->default(true);
            $table->integer('tahun')->nullable()->comment('Tahun spesifik untuk acara non-berulang');
            $table->timestamps();
            $table->index('tanggal');
            $table->index('tipe_acara');
            $table->index('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acara_buddhist');
    }
};