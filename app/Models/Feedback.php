<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'nama_pengirim',
        'kontak',
        'klaster_id',
        'subjek',
        'isi_pesan',
        'status',
        'catatan_internal',
    ];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(KlasterILP::class, 'klaster_id');
    }
}
