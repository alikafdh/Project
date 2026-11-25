<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPuskesmas extends Model
{
    use HasFactory;

    protected $table = 'profil_puskesmas';

    protected $fillable = [
        'visi',
        'misi',
        'wilayah_kerja',
        'logo',
        'foto_fasilitas',
        'strukt_organisasi',
        'no_telepon',
        'alamat',
        'email',
        'koordinat_peta',
        'wa_number',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}
