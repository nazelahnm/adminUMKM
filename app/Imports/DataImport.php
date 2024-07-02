<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Data([
            'kelurahan_id' => $row['kelurahan_id'], // Pastikan ini integer
            'nama_umkm' => $row['nama_umkm'],
            'laba_bersih' => $row['laba_bersih'],
            'omset' => $row['omset'],
            'jumlah_karyawan' => $row['jumlah_karyawan'],
            'modal' => $row['modal'],
            'usia' => $row['usia'],
            'lokasi' => $row['lokasi'],
        ]);
    }
}
