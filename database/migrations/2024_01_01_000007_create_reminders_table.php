<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien', 100);
            $table->string('nomor_wa', 30); // Format E.164: +628...
            $table->foreignId('klaster_id')->constrained('klaster_ilp')->onDelete('restrict');
            $table->enum('tipe_interval', ['sekali', 'bulanan'])->default('bulanan');
            $table->unsignedTinyInteger('hari_ke')->nullable(); // Angka hari (1-31) jika jadwal berulang bulanan
            $table->date('tanggal_spesifik')->nullable();       // Tanggal jika pengingat sekali jalan
            $table->time('jam_kirim')->default('08:00:00');     // Waktu pengiriman
            $table->dateTime('next_run_at')->nullable()->index(); // Waktu eksekusi cron scheduler berikutnya
            $table->string('jadwal', 100)->nullable();          // Keterangan label human-readable (e.g. "Setiap Tgl 24")
            $table->text('template_pesan')->nullable();         // Template pesan token: {nama_pasien}, {tanggal}, dll.
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
