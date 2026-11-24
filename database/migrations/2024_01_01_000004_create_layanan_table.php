<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_poli', 100);
            $table->string('slug', 100)->unique();
            $table->text('deskripsi')->nullable(); // Penjelasan pelayanan & tindakan medis poli
            $table->text('jadwal_praktik')->default('Senin–Jumat | 07:30–12:00 WIB');
            $table->string('tenaga_medis', 150)->nullable(); // Dokter / Bidan PJ
            $table->string('gambar_alur')->nullable(); // Gambar alur khusus poli bila ada
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->foreignId('klaster_id')->constrained('klaster_ilp')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
