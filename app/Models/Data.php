<?php

namespace App\Models;
use App\Models\Kelurahan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kelurahan_id', 'nama_umkm', 'laba_bersih', 'omset', 'jumlah_karyawan', 'modal', 'usia', 'lokasi'
    ];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }
}
