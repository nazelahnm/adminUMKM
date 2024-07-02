<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Imports\DataImport;
use App\Models\Kriteria;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = Data::all();
        $paginate = Data::where('kelurahan_id', $id)->orderBy('id', 'asc')->paginate(20);

        return view(
            'admin.admin_crud.kelurahan.data',
            [
                'data' => $data,
                'paginate' => $paginate,
                'kelurahan_id' => $id
            ]
        );
    }

    public function showUploadForm()
    {
        return view('admin.admin_crud.kelurahan.index');
    }

    public function dataimportexcel(Request $request)
    {
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Data', $namaFile);
        $kelurahanId = $request->input('kelurahan_id');

        Excel::import(new DataImport, public_path('Data/' . $namaFile));
        return redirect()->route('data.index', ['id' => $kelurahanId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data berdasarkan id_kelurahan
        $data = Data::where('kelurahan_id', $id)->first();

        // Paginasi data yang difilter berdasarkan id_kelurahan
        $paginate = Data::where('kelurahan_id', $id)
            ->orderBy('id', 'asc')
            ->paginate(20);

        // Tampilkan view dengan data yang sudah difilter
        return view(
            'admin.admin_crud.kelurahan.data',
            [
                'data' => $data,
                'paginate' => $paginate,
                'kelurahan_id' => $id
            ]
        );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function hitung($kelurahan_id, Request $request)
    {
        $size = $request->has('size') ? intval($request->input('size')) : 10; //menentukan ukuran paginasi berdasarkan input request atau menggunakan nilai default 10.
        $data = Data::where('kelurahan_id', '=', $kelurahan_id)->first(); //mengambil data pertama yang cocok dengan kelurahan_id yang diberikan dari tabel Data.
        $kriteria = Kriteria::all(); //mengambil semua data dari tabel Kriteria.

        // mengambil data dari tabel Data berdasarkan kelurahan_id, 
        // mengurutkannya berdasarkan id, dan melakukan paginasi. Setelah itu, 
        // setiap elemen hasil paginasi diubah dengan mengganti nilai lokasi menjadi 
        // nilai numerik tertentu berdasarkan kondisi yang telah ditentukan, dan 
        // menambahkan properti lokasiValue dengan nilai yang sama. Hasil akhirnya 
        // disimpan dalam variabel $paginate.    
        $paginate = Data::where('kelurahan_id', $kelurahan_id)
            ->orderBy('id', 'asc')
            ->paginate($size)->through(function ($dt) {
                // Mengubah nilai lokasi menjadi angka berdasarkan kondisi tertentu
                switch ($dt->lokasi) {
                    case 'Kurang Layak':
                        $lokasiValue = 5;
                        break;
                    case 'Belum Layak':
                        $lokasiValue = 4;
                        break;
                    case 'Cukup Layak':
                        $lokasiValue = 3;
                        break;
                    case 'Layak':
                        $lokasiValue = 2;
                        break;
                    case 'Sangat Layak':
                        $lokasiValue = 1;
                        break;
                    default:
                        $lokasiValue = 0;
                        break;
                }

                $dt->lokasi = $lokasiValue;
                $dt->lokasiValue = $lokasiValue;


                return $dt;
            });;
        
        // Kode ini melakukan query untuk mengambil data dari 
        // tabel Data berdasarkan kelurahan_id, mengurutkan data 
        // berdasarkan kolom id, dan kemudian mengubah setiap elemen 
        // dalam hasil query. Nilai lokasi dari setiap elemen diubah 
        // menjadi nilai numerik berdasarkan kondisi tertentu, 
        // dan nilai ini juga disimpan dalam properti baru lokasiValue. 
        // Hasil akhir, yang merupakan koleksi data yang telah dimodifikasi, 
        // disimpan dalam variabel $data.
        $data = Data::where('kelurahan_id', $kelurahan_id)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($dt) {
                // Mengubah nilai lokasi menjadi angka berdasarkan kondisi tertentu
                switch ($dt->lokasi) {
                    case 'Kurang Layak':
                        $lokasiValue = 5;
                        break;
                    case 'Belum Layak':
                        $lokasiValue = 4;
                        break;
                    case 'Cukup Layak':
                        $lokasiValue = 3;
                        break;
                    case 'Layak':
                        $lokasiValue = 2;
                        break;
                    case 'Sangat Layak':
                        $lokasiValue = 1;
                        break;
                    default:
                        $lokasiValue = 0;
                        break;
                }

                $dt->lokasi = $lokasiValue;
                $dt->lokasiValue = $lokasiValue;


                return $dt;
            });;

        // Definisikan kolom kriteria
        $criteriaColumns = [
            'laba_bersih' => 'Laba Bersih',
            'omset' => 'Omset',
            'jumlah_karyawan' => 'Jumlah Karyawan',
            'modal' => 'Modal',
            'usia' => 'Usia',
            'lokasi' => 'Lokasi'
        ];

        // Kode ini melakukan iterasi melalui setiap kolom kriteria yang telah ditentukan. 
        // Untuk kolom lokasi, kode mengonversi nilai lokasi menjadi nilai numerik yang sesuai 
        // dan kemudian menentukan nilai maksimum dan minimum untuk lokasi. Untuk kolom lainnya, 
        // kode mengambil nilai maksimum dan minimum langsung dari database. Hasil akhir adalah 
        // dua array ($maxValues dan $minValues) yang menyimpan nilai maksimum dan minimum untuk 
        // setiap kolom kriteria.
        $maxValues = [];
        $minValues = [];
        foreach ($criteriaColumns as $columnName => $columnLabel) {


            if ($columnName === 'lokasi') {
                $locations = Data::where('kelurahan_id', $kelurahan_id)->pluck('lokasi');

                foreach ($locations as $lokasi) {
                    switch ($lokasi) {
                        case 'Kurang Layak':
                            $lokasiValue = 5;
                            break;
                        case 'Belum Layak':
                            $lokasiValue = 4;
                            break;
                        case 'Cukup Layak':
                            $lokasiValue = 3;
                            break;
                        case 'Layak':
                            $lokasiValue = 2;
                            break;
                        case 'Sangat Layak':
                            $lokasiValue = 1;
                            break;
                        default:
                            $lokasiValue = 0;
                            break;
                    }


                    if (!isset($maxValues[$columnName]) || $lokasiValue > $maxValues[$columnName]) {
                        $maxValues[$columnName] = $lokasiValue;
                    }

                    if (!isset($minValues[$columnName]) || $lokasiValue < $minValues[$columnName]) {
                        $minValues[$columnName] = $lokasiValue;
                    }
                }
            } else {

                $maxValues[$columnName] = Data::where('kelurahan_id', '=', $kelurahan_id)->max($columnName);
                $minValues[$columnName] = Data::where('kelurahan_id', '=', $kelurahan_id)->min($columnName);
            }
        }


        // Menghitung nilai Tij (langkah normalisasi matriks keputusan)
        $T = [];
        foreach ($data as $dt) {


            $T_row = [];
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $xij = $dt->$columnName; //Mengambil nilai dari kolom kriteria saat ini ($columnName) untuk data saat ini
                $xiPlus = $maxValues[$columnName]; //Mengambil nilai maksimum untuk kolom kriteria saat ini dari array $maxValues.
                $xiMinus = $minValues[$columnName]; //Mengambil nilai minimum untuk kolom kriteria saat ini dari array $minValues.
                $criteria = Kriteria::where('kriteria', $columnName)->first();
                $jenis = $criteria ? $criteria->jenis : 'Invalid criteria'; //Mengambil jenis kriteria (benefit atau cost). Jika objek kriteria tidak ditemukan, nilai default adalah 'Invalid criteria'.


                if ($xiPlus - $xiMinus != 0) { //Memeriksa apakah selisih antara nilai maksimum dan minimum tidak sama dengan nol untuk menghindari pembagian dengan nol.
                    if ($jenis == 'benefit') {
                        $tij = ($xij - $xiMinus) / ($xiPlus - $xiMinus); //
                    } elseif ($jenis == 'cost') {
                        $tij = ($xij - $xiPlus) / ($xiMinus - $xiPlus);
                    } else {
                        $tij = 'Invalid criteria type';
                    }
                } else {
                    $tij = 0; //Jika selisih antara nilai maksimum dan minimum sama dengan nol, nilai transformasi ($tij) disetel menjadi nol.
                }

                $tij = max(0, $tij);
                $T_row[$columnName] = $tij;
            }

            $T_row['nama_umkm'] = $dt->nama_umkm; //Menyimpan nama UMKM ke dalam array $T_row.

            $T[] = $T_row;
        }

        // Menghitung Vij (Langkah Elemen Matriks Tertimbang)
        $V = [];
        foreach ($T as $T_row) {
            $V_row = []; //Membuat array kosong $V_row untuk menyimpan nilai $V untuk satu baris data.
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $tij = $T_row[$columnName]; //Mengambil nilai transformasi ($T_ij) untuk kolom kriteria saat ini dari array $T_row.
                $weight = Kriteria::where('kriteria', $columnName)->first()->bobot; //Mengambil bobot dari kriteria yang sesuai dengan kolom kriteria saat ini dari model Kriteria.
                $v_ij = $weight * $tij + $weight; //Menghitung nilai $V_ij
                $V_row[$columnName] = $v_ij; //Menyimpan nilai $V_ij ke dalam array $V_row untuk kolom kriteria saat ini.
            }

            $V_row['nama_umkm'] = $T_row['nama_umkm']; //Menambahkan nama UMKM (yang disimpan dalam array $T_row) ke dalam array $V_row.

            $V[] = $V_row; //Menambahkan array $V_row yang berisi nilai $V 
                            //untuk satu baris data ke dalam array $V. Setelah 
                            //iterasi selesai, array $V akan berisi semua baris 
                            //data dengan nilai $V yang telah dihitung.
        }

        // Menghitung Gj
        $m = count($data); //Menghitung jumlah alternatif yang dihitung sebelumnya dan disimpan dalam array $data.
        $G = []; //Menginisialisasi array kosong $G yang akan digunakan untuk menyimpan nilai Gj untuk setiap kriteria

        foreach ($criteriaColumns as $columnName => $columnLabel) {
            $productVij = 1;
            foreach ($V as $V_row) {
                $productVij *= $V_row[$columnName]; //Mengalikan nilai $productVij dengan nilai Vij dari baris $V_row untuk kolom kriteria saat ini ($columnName)
            }
            $Gj = pow($productVij, 1 / $m); //Menghitung nilai Gj dengan menggunakan fungsi pow untuk menghitung akar pangkat 1/𝑚 dari produk nilai Vij
            $G[$columnName] = $Gj; //Menyimpan nilai Gj yang telah dihitung ke dalam array $G, dengan kunci berupa nama kolom kriteria ($columnName).
        }

        $page = $request->has('page') ? intval($request->input('page')) : 1;

        // Menghitung Qij dan Si
        $S_data = []; //Inisialisasi array kosong $S_data yang akan digunakan untuk menyimpan hasil perhitungan nilai Si untuk setiap UMKM.
        foreach ($V as $index => &$V_row) {
            $Si = 0;
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $Qij = $V_row[$columnName] - $G[$columnName]; //Menghitung Qij​
                $V_row["qij_$columnName"] = $Qij; //Menyimpan Qij dalam Variabel Baru
                $Si += $Qij; //Menambahkan nilai Qij ke variabel Si. Setelah iterasi selesai, variabel Si akan berisi total dari seluruh Qij untuk UMKM saat ini.
            }

            $S_data[] = [
                'nama_umkm' => $V_row['nama_umkm'],
                'Si' => $Si
            ];
        }



        // Urutkan data berdasarkan nilai S
        usort($S_data, function ($a, $b) {
            return $b['Si'] <=> $a['Si'];
        });



        $offset = ($page - 1) * $size;
        $S_data =  array_slice($S_data, $offset, $size);

        return view('admin.admin_crud.kelurahan.hitung', compact('paginate', 'criteriaColumns', 'maxValues', 'minValues', 'T', 'V', 'G', 'S_data', 'offset'));
    }

    public function hasil($kelurahan_id, Request $request)
    {
        $size = $request->has('size') ? intval($request->input('size')) : 10;
        $data = Data::where('kelurahan_id', '=', $kelurahan_id)->first();
        $kriteria = Kriteria::all();

        $paginate = Data::where('kelurahan_id', $kelurahan_id)
            ->orderBy('id', 'asc')
            ->paginate($size)->through(function ($dt) {
                // Mengubah nilai lokasi menjadi angka berdasarkan kondisi tertentu
                switch ($dt->lokasi) {
                    case 'Kurang Layak':
                        $lokasiValue = 5;
                        break;
                    case 'Belum Layak':
                        $lokasiValue = 4;
                        break;
                    case 'Cukup Layak':
                        $lokasiValue = 3;
                        break;
                    case 'Layak':
                        $lokasiValue = 2;
                        break;
                    case 'Sangat Layak':
                        $lokasiValue = 1;
                        break;
                    default:
                        $lokasiValue = 0;
                        break;
                }

                $dt->lokasi = $lokasiValue;
                $dt->lokasiValue = $lokasiValue;


                return $dt;
            });;

        $data = Data::where('kelurahan_id', $kelurahan_id)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($dt) {
                // Mengubah nilai lokasi menjadi angka berdasarkan kondisi tertentu
                switch ($dt->lokasi) {
                    case 'Kurang Layak':
                        $lokasiValue = 5;
                        break;
                    case 'Belum Layak':
                        $lokasiValue = 4;
                        break;
                    case 'Cukup Layak':
                        $lokasiValue = 3;
                        break;
                    case 'Layak':
                        $lokasiValue = 2;
                        break;
                    case 'Sangat Layak':
                        $lokasiValue = 1;
                        break;
                    default:
                        $lokasiValue = 0;
                        break;
                }

                $dt->lokasi = $lokasiValue;
                $dt->lokasiValue = $lokasiValue;


                return $dt;
            });;

        // Definisikan kolom kriteria
        $criteriaColumns = [
            'laba_bersih' => 'Laba Bersih',
            'omset' => 'Omset',
            'jumlah_karyawan' => 'Jumlah Karyawan',
            'modal' => 'Modal',
            'usia' => 'Usia',
            'lokasi' => 'Lokasi'
        ];

        // Menghitung nilai max dan min
        $maxValues = [];
        $minValues = [];
        foreach ($criteriaColumns as $columnName => $columnLabel) {


            if ($columnName === 'lokasi') {
                $locations = Data::where('kelurahan_id', $kelurahan_id)->pluck('lokasi');

                foreach ($locations as $lokasi) {
                    switch ($lokasi) {
                        case 'Kurang Layak':
                            $lokasiValue = 5;
                            break;
                        case 'Belum Layak':
                            $lokasiValue = 4;
                            break;
                        case 'Cukup Layak':
                            $lokasiValue = 3;
                            break;
                        case 'Layak':
                            $lokasiValue = 2;
                            break;
                        case 'Sangat Layak':
                            $lokasiValue = 1;
                            break;
                        default:
                            $lokasiValue = 0;
                            break;
                    }


                    if (!isset($maxValues[$columnName]) || $lokasiValue > $maxValues[$columnName]) {
                        $maxValues[$columnName] = $lokasiValue;
                    }

                    if (!isset($minValues[$columnName]) || $lokasiValue < $minValues[$columnName]) {
                        $minValues[$columnName] = $lokasiValue;
                    }
                }
            } else {

                $maxValues[$columnName] = Data::where('kelurahan_id', '=', $kelurahan_id)->max($columnName);
                $minValues[$columnName] = Data::where('kelurahan_id', '=', $kelurahan_id)->min($columnName);
            }
        }


        // Menghitung nilai T_ij
        $T = [];
        foreach ($data as $dt) {


            $T_row = [];
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $xij = $dt->$columnName;
                $xiPlus = $maxValues[$columnName];
                $xiMinus = $minValues[$columnName];
                $criteria = Kriteria::where('kriteria', $columnName)->first();
                $jenis = $criteria ? $criteria->jenis : 'Invalid criteria';


                if ($xiPlus - $xiMinus != 0) {
                    if ($jenis == 'benefit') {
                        $tij = ($xij - $xiMinus) / ($xiPlus - $xiMinus);
                    } elseif ($jenis == 'cost') {
                        $tij = ($xij - $xiPlus) / ($xiMinus - $xiPlus);
                    } else {
                        $tij = 'Invalid criteria type';
                    }
                } else {
                    $tij = 0; // Nilai default jika pembagi nol
                }

                $tij = max(0, $tij);
                $T_row[$columnName] = $tij;
            }

            $T_row['nama_umkm'] = $dt->nama_umkm;

            $T[] = $T_row;
        }

        // Menghitung V_ij
        $V = [];
        foreach ($T as $T_row) {
            $V_row = [];
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $tij = $T_row[$columnName];
                $weight = Kriteria::where('kriteria', $columnName)->first()->bobot;
                $v_ij = $weight * $tij + $weight;
                $V_row[$columnName] = $v_ij;
            }

            $V_row['nama_umkm'] = $T_row['nama_umkm'];

            $V[] = $V_row;
        }

        // Menghitung G_j
        $m = count($data);
        $G = [];

        foreach ($criteriaColumns as $columnName => $columnLabel) {
            $productVij = 1;
            foreach ($V as $V_row) {
                $productVij *= $V_row[$columnName];
            }
            $Gj = pow($productVij, 1 / $m);
            $G[$columnName] = $Gj;
        }

        $page = $request->has('page') ? intval($request->input('page')) : 1;

        // Menghitung Q_ij dan S_i
        $S_data = [];
        foreach ($V as $index => &$V_row) {
            $Si = 0;
            foreach ($criteriaColumns as $columnName => $columnLabel) {
                $Qij = $V_row[$columnName] - $G[$columnName];
                $V_row["qij_$columnName"] = $Qij;
                $Si += $Qij;
            }

            $S_data[] = [
                'nama_umkm' => $V_row['nama_umkm'],
                'Si' => $Si
            ];
        }



        // Urutkan data berdasarkan nilai S secara menurun
        usort($S_data, function ($a, $b) {
            return $b['Si'] <=> $a['Si'];
        });



        $offset = ($page - 1) * $size;
        $S_data =  array_slice($S_data, $offset, $size);

        return view('admin.admin_crud.perankingan.hasil', compact('paginate', 'criteriaColumns', 'maxValues', 'minValues', 'T', 'V', 'G', 'S_data', 'offset'));
    }
    
}
