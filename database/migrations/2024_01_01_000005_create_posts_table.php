<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->longText('isi');
            $table->enum('tipe', ['laporan', 'berita', 'agenda'])->default('berita');
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->string('foto_thumbnail')->nullable();
            $table->string('file_pdf')->nullable(); // Khusus laporan akuntabilitas
            $table->string('periode_bulan', 20)->nullable(); // Khusus laporan (e.g. "Oktober")
            $table->year('periode_tahun')->nullable(); // Khusus laporan (e.g. 2026)
            $table->dateTime('waktu_kegiatan')->nullable(); // Khusus agenda kegiatan
            $table->string('lokasi_kegiatan', 255)->nullable(); // Khusus agenda
            $table->string('sasaran_peserta', 255)->nullable(); // Khusus agenda
            $table->unsignedBigInteger('views')->default(0); // Jumlah tayangan pembaca
            $table->foreignId('klaster_id')->nullable()->constrained('klaster_ilp')->onDelete('set null');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
