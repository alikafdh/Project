<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KlasterILP extends Model
{
    use HasFactory;

    protected $table = 'klaster_ilp';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    public function layanan(): HasMany
    {
        return $this->hasMany(Layanan::class, 'klaster_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'klaster_id');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class, 'klaster_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'klaster_id');
    }
}
