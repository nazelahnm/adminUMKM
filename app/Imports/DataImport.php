<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;

class DataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            'kelurahan_id' => $row[1],
            'nama_umkm' => $row[2],
            'laba_bersih' => $row[3],
            'omset' => $row[4],
            'jumlah_karyawan' => $row[5],
            'modal' => $row[6],
            'usia' => $row[7],
            'lokasi' => $row[8],
        ]);
    }
}
