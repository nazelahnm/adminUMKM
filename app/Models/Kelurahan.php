<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'tahun_id', 'id');
    }
}
