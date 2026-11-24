<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'nomor_wa',
        'klaster_id',
        'tipe_interval',
        'hari_ke',
        'tanggal_spesifik',
        'jam_kirim',
        'next_run_at',
        'jadwal',
        'template_pesan',
        'status',
    ];

    protected $casts = [
        'next_run_at'      => 'datetime',
        'tanggal_spesifik' => 'date',
        'hari_ke'          => 'integer',
    ];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(KlasterILP::class, 'klaster_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ReminderLog::class, 'reminder_id');
    }
}
