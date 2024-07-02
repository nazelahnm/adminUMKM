<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahuns'; // Nama tabel di database

    // Atribut yang dapat diisi secara massal (jika ada)
    protected $fillable = [
        'year',
        // tambahkan atribut lain yang ingin Anda isikan secara massal
    ];

    // Relasi ke model Kelurahan jika diperlukan
    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class, 'tahun_id', 'id');
    }
}
