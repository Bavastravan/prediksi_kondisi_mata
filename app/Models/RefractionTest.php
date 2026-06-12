<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefractionTest extends Model
{
    use HasFactory;

    // Izinkan field ini diisi melalui proses create() di controller
    protected $fillable = [
        'user_id',
        'type',
        'va_score',
        'conclusion',
        'confidence',
    ];

    // Relasi balik ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}