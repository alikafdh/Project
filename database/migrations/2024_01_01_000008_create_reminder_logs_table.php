<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_logs', function (Blueprint $table) {
            $table->id();
            // R7 Komposisi: Jika data reminder dihapus, seluruh riwayat log terkait ikut terhapus (cascade)
            $table->foreignId('reminder_id')->constrained('reminders')->onDelete('cascade');
            $table->dateTime('waktu_kirim');
            $table->text('pesan_terkirim')->nullable(); // Teks riil pesan setelah substitusi token
            $table->enum('status', ['berhasil', 'gagal', 'pending'])->default('pending');
            $table->string('keterangan', 255)->nullable(); // Log status dari WhatsApp Gateway
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_logs');
    }
};
