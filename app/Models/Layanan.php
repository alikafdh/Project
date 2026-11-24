<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_poli',
        'slug',
        'deskripsi',
        'jadwal_praktik',
        'tenaga_medis',
        'gambar_alur',
        'status',
        'klaster_id',
    ];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(KlasterILP::class, 'klaster_id');
    }
}
