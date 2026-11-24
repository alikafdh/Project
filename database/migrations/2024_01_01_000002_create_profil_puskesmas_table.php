<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_puskesmas', function (Blueprint $table) {
            $table->id();
            $table->text('visi');
            $table->json('misi'); // Format JSON Array
            $table->text('wilayah_kerja')->nullable();
            $table->string('logo')->nullable(); // Logo resmi puskesmas / pemda
            $table->string('foto_fasilitas')->nullable();
            $table->string('strukt_organisasi')->nullable(); // Path aset bagan SOTK
            $table->string('no_telepon', 30)->default('(0232) 8611118');
            $table->string('alamat', 255)->default('Jl. Raya Cilimus No. 219, Kec. Cilimus, Kab. Kuningan, Jawa Barat 45556');
            $table->string('email', 100)->default('puskesmascilimus@kuningankab.go.id');
            $table->string('koordinat_peta', 150)->nullable();
            $table->string('wa_number', 30)->default('6281123456789');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_puskesmas');
    }
};
