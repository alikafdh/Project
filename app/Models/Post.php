<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'tipe',
        'status',
        'foto_thumbnail',
        'file_pdf',
        'periode_bulan',
        'periode_tahun',
        'waktu_kegiatan',
        'lokasi_kegiatan',
        'sasaran_peserta',
        'views',
        'klaster_id',
        'admin_id',
    ];

    protected $casts = [
        'waktu_kegiatan' => 'datetime',
        'periode_tahun'  => 'integer',
        'views'          => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->judul) . '-' . Str::random(5);
            }
        });
    }

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(KlasterILP::class, 'klaster_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
