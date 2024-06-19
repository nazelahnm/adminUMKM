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
