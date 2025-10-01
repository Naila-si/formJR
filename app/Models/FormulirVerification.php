<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FormulirVerification extends Model
{
    protected $fillable = [
        'formulir_id',
        'user_id',
        'status',
        'notes',
    ];

     public function formulir()
    {
        return $this->belongsTo(Formulir::class);
    }

    // Relasi ke User (admin yang verifikasi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
