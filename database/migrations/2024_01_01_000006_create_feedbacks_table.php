<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengirim', 100);
            $table->string('kontak', 100); // Nomor WA atau Email warga
            $table->foreignId('klaster_id')->nullable()->constrained('klaster_ilp')->onDelete('set null');
            $table->string('subjek', 200);
            $table->text('isi_pesan');
            $table->enum('status', ['baru', 'dibaca', 'selesai'])->default('baru');
            $table->text('catatan_internal')->nullable(); // Catatan tindak lanjut staf
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
