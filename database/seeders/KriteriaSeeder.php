<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kriterias')->insert([[
            'kriteria' => 'Laba_Bersih',
            'bobot' => '0.2',
            'jenis' => 'cost',
            'keterangan' => 'Semakin tinggi laba bersih, maka akan lebih sulit untuk menerima dana bantuan'
        ],
        [
            'kriteria' => 'Omset',
            'bobot' => '0.25',
            'jenis' => 'cost',
            'keterangan' => 'Semakin tinggi omset, maka akan lebih sulit untuk menerima dana bantuan'
        ],
        [
            'kriteria' => 'jumlah_karyawan',
            'bobot' => '0.15',
            'jenis' => 'benefit',
            'keterangan' => 'Semakin banyak karyawan dalam UMKM tersebut, pemerintah akan lebih sering memberikan bantuan'
        ],
        [
            'kriteria' => 'modal',
            'bobot' => '0.1',
            'jenis' => 'cost',
            'keterangan' => 'Semakin tinggi modal, maka akan lebih sulit untuk menerima dana bantuan'
        ],
        [
            'kriteria' => 'usia',
            'bobot' => '0.2',
            'jenis' => 'cost',
            'keterangan' => 'Semakin lama usia UMKM, maka akan lebih sulit untuk menerima dana bantuan'
        ],
        [
            'kriteria' => 'Lokasi',
            'bobot' => '0.1',
            'jenis' => 'benefit',
            'keterangan' => 'Semakin strategis letak lokasi usaha, maka akan lebih mudah untuk menerima dana bantuan'
        ],]       
    );
    }
}
