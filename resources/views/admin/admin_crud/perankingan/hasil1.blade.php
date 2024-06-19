@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hasil Perhitungan MABAC</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Perankingan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <h6>Langkah 1 (Pembentukan Matriks Keputusan Awal (X))</h6>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Laba Bersih</th>
                                        <th>Omset</th>
                                        <th>Jumlah Karyawan</th>
                                        <th>Modal</th>
                                        <th>Usia</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginate as $index => $dt)
                                    <tr>
                                        <th scope="row">{{$paginate->firstItem() + $index}}</th>
                                        <td>{{$dt -> nama_umkm}}</td>
                                        <td>{{$dt -> laba_bersih / 1000000}}</td>
                                        <td>{{$dt -> omset / 1000000}}</td>
                                        <td>{{$dt -> jumlah_karyawan}}</td>
                                        <td>{{$dt -> modal / 1000000}}</td>
                                        <td>{{$dt -> usia}}</td>
                                        <td>
                                            @php
                                            $lokasiValue = '';
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
                                            // handle default case here, if needed
                                            break;
                                            }
                                            echo $lokasiValue;
                                            @endphp
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                @if ($paginate->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $paginate->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                @foreach ($paginate->getUrlRange(1, $paginate->lastPage()) as $page => $url)
                                @if ($page == $paginate->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach

                                @if ($paginate->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $paginate->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div> <br> <br>

                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <h6>Langkah 2 (Normalisasi Matriks Keputusan Awal(X))</h6>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Laba Bersih</th>
                                        <th>Omset</th>
                                        <th>Jumlah Karyawan</th>
                                        <th>Modal</th>
                                        <th>Usia</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $maxValues = array_fill(0, 6, PHP_INT_MIN);
                                    $minValues = array_fill(0, 6, PHP_INT_MAX);
                                    @endphp
                                    @foreach ($paginate as $index => $dt)
                                    @php
                                    // Menentukan nilai lokasi
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
                                    @endphp
                                    <tr>
                                        <th scope="row">{{$paginate->firstItem() + $index}}</th>
                                        <td>{{$dt->nama_umkm}}</td>
                                        <td>{{$dt->laba_bersih / 1000000}}</td>
                                        <td>{{$dt->omset / 1000000}}</td>
                                        <td>{{$dt->jumlah_karyawan}}</td>
                                        <td>{{$dt->modal / 1000000}}</td>
                                        <td>{{$dt->usia}}</td>
                                        <td>{{ $lokasiValue }}</td>
                                        @php
                                        // Update nilai max dan min untuk setiap kolom
                                        $maxValues[0] = max($maxValues[0], $dt->laba_bersih);
                                        $maxValues[1] = max($maxValues[1], $dt->omset);
                                        $maxValues[2] = max($maxValues[2], $dt->jumlah_karyawan);
                                        $maxValues[3] = max($maxValues[3], $dt->modal);
                                        $maxValues[4] = max($maxValues[4], $dt->usia);
                                        $maxValues[5] = max($maxValues[5], $lokasiValue);

                                        $minValues[0] = min($minValues[0], $dt->laba_bersih);
                                        $minValues[1] = min($minValues[1], $dt->omset);
                                        $minValues[2] = min($minValues[2], $dt->jumlah_karyawan);
                                        $minValues[3] = min($minValues[3], $dt->modal);
                                        $minValues[4] = min($minValues[4], $dt->usia);
                                        $minValues[5] = min($minValues[5], $lokasiValue);
                                        @endphp
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2">Nilai Max</td>
                                        @foreach ($maxValues as $maxValue)
                                        <td>{{ $maxValue / 100000 }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td colspan="2">Nilai Min</td>
                                        @foreach ($minValues as $minValue)
                                        <td>{{ $minValue / 100000 }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>

                            <table id="hasil_mabac" class="table table-bordered text-center">
                                <h6>Hasil</h6>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Laba Bersih</th>
                                        <th>Omset</th>
                                        <th>Jumlah Karyawan</th>
                                        <th>Modal</th>
                                        <th>Usia</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $laba_bersihMax = 0;
                                    $laba_bersihMin = PHP_INT_MAX;
                                    $omsetMax = 0;
                                    $omsetMin = PHP_INT_MAX;
                                    $jumlah_karyawanMax = 0;
                                    $jumlah_karyawanMin = PHP_INT_MAX;
                                    $modalMax = 0;
                                    $modalMin = PHP_INT_MAX;
                                    $usiaMax = 0;
                                    $usiaMin = PHP_INT_MAX;
                                    $lokasiMax = 0;
                                    $lokasiMin = PHP_INT_MAX;

                                    // Lakukan perhitungan untuk mencari nilai maksimum dan minimum
                                    foreach ($paginate as $dt) {
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

                                    $laba_bersihMax = max($laba_bersihMax, $dt->laba_bersih);
                                    $laba_bersihMin = min($laba_bersihMin, $dt->laba_bersih);
                                    $omsetMax = max($omsetMax, $dt->omset);
                                    $omsetMin = min($omsetMin, $dt->omset);
                                    $jumlah_karyawanMax = max($jumlah_karyawanMax, $dt->jumlah_karyawan);
                                    $jumlah_karyawanMin = min($jumlah_karyawanMin, $dt->jumlah_karyawan);
                                    $modalMax = max($modalMax, $dt->modal);
                                    $modalMin = min($modalMin, $dt->modal);
                                    $usiaMax = max($usiaMax, $dt->usia);
                                    $usiaMin = min($usiaMin, $dt->usia);
                                    $lokasiMax = max($lokasiMax, $lokasiValue);
                                    $lokasiMin = min($lokasiMin, $lokasiValue);
                                    }

                                    // Definisikan kolom kriteria
                                    $criteriaColumns = [
                                    'laba_bersih' => 'Laba Bersih',
                                    'omset' => 'Omset',
                                    'jumlah_karyawan' => 'Jumlah Karyawan',
                                    'modal' => 'Modal',
                                    'usia' => 'Usia',
                                    'lokasi' => 'Lokasi'
                                    ];
                                    @endphp
                                    @foreach ($paginate as $index => $dt)
                                    @php
                                    // Menentukan nilai lokasi untuk setiap iterasi
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
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $paginate->firstItem() + $index }}</th>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        @foreach (['laba_bersih', 'omset', 'jumlah_karyawan', 'modal', 'usia', 'lokasi'] as $columnName)
                                        @php
                                        $xij = ($columnName == 'lokasi') ? $lokasiValue : $dt->$columnName;
                                        $xiPlus = ($columnName == 'laba_bersih') ? $laba_bersihMax :
                                        (($columnName == 'omset') ? $omsetMax :
                                        (($columnName == 'jumlah_karyawan') ? $jumlah_karyawanMax :
                                        (($columnName == 'modal') ? $modalMax :
                                        (($columnName == 'usia') ? $usiaMax :
                                        (($columnName == 'lokasi') ? $lokasiMax : 0)))));
                                        $xiMinus = ($columnName == 'laba_bersih') ? $laba_bersihMin :
                                        (($columnName == 'omset') ? $omsetMin :
                                        (($columnName == 'jumlah_karyawan') ? $jumlah_karyawanMin :
                                        (($columnName == 'modal') ? $modalMin :
                                        (($columnName == 'usia') ? $usiaMin :
                                        (($columnName == 'lokasi') ? $lokasiMin : 0)))));

                                        // Ambil jenis kriteria dari tabel kriteria
                                        $criteria = App\Models\Kriteria::where('kriteria', $columnName)->first();
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
                                        @endphp
                                        <td>{{ $tij }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="hasil_mabac" class="table table-bordered text-center">
                                <h6>Langkah 3 (Perhitungan Elemen Matriks Tertimbang (V))</h6>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        @foreach ($criteriaColumns as $columnLabel)
                                        <th>{{ $columnLabel }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    $V = [];
                                    @endphp
                                    @foreach ($paginate as $index => $dt)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        @php
                                        $V_row = [];
                                        @endphp
                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        @php
                                        // Menentukan nilai lokasi
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
                                        // Mendapatkan nilai $t_ij dari data sebelumnya
                                        $xij = ($columnName == 'lokasi') ? $lokasiValue : $dt->$columnName;
                                        $xiPlus = ($columnName == 'laba_bersih') ? $laba_bersihMax :
                                        (($columnName == 'omset') ? $omsetMax :
                                        (($columnName == 'jumlah_karyawan') ? $jumlah_karyawanMax :
                                        (($columnName == 'modal') ? $modalMax :
                                        (($columnName == 'usia') ? $usiaMax :
                                        (($columnName == 'lokasi') ? $lokasiMax : 0)))));
                                        $xiMinus = ($columnName == 'laba_bersih') ? $laba_bersihMin :
                                        (($columnName == 'omset') ? $omsetMin :
                                        (($columnName == 'jumlah_karyawan') ? $jumlah_karyawanMin :
                                        (($columnName == 'modal') ? $modalMin :
                                        (($columnName == 'usia') ? $usiaMin :
                                        (($columnName == 'lokasi') ? $lokasiMin : 0)))));

                                        // Ambil jenis kriteria dari tabel kriteria
                                        $criteria = \App\Models\Kriteria::where('kriteria', $columnName)->first();
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

                                        // Mendapatkan bobot (w) dari tabel kriteria
                                        $weight = \App\Models\Kriteria::where('kriteria', $columnName)->first()->bobot;

                                        // Menghitung V_ij
                                        $v_ij = $weight * $tij + $weight;

                                        // Menyimpan nilai V_ij untuk setiap kriteria
                                        $V_row[] = $v_ij;
                                        @endphp
                                        <td>{{ $v_ij }}</td>
                                        @endforeach
                                        @php
                                        $V[] = $V_row;
                                        @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table><br>
                        </div>
                    </div>

                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="hasil_mabac" class="table table-bordered text-center">
                                <h6>Langkah 4 (Penentuan Matriks Area Perkiraan Perbatasan (G))</h6>
                                <thead>
                                    <tr>
                                        @foreach ($criteriaColumns as $columnLabel)
                                        <th>{{ $columnLabel }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                        $m = count($paginate);
                                        $G = [];
                                        @endphp
                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        @php
                                        // Menghitung G_j untuk setiap kriteria
                                        $productVij = array_product(array_column($V, $loop->index));
                                        $Gj = pow($productVij, 1 / $m);
                                        $G[] = $Gj;
                                        @endphp
                                        <td>{{ $Gj }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table><br>
                        </div>
                    </div>

                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="hasil_mabac" class="table table-bordered text-center">
                                <h6>Langkah 5 (Jarak Alternatif dari Perkiraan Perbatasan)</h6>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        @foreach ($criteriaColumns as $columnLabel)
                                        <th>{{ $columnLabel }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach ($paginate as $index => $dt)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        @php
                                        // Menghitung Q_ij
                                        $Qij = $V[$index][$loop->index] - $G[$loop->index];
                                        @endphp
                                        <td>{{ $Qij }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table><br>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table id="hasil_perankingan" class="table table-bordered text-center">
                                <center>
                                    <font size="6">
                                        <b>HASIL PERANKINGAN</b>
                                    </font>
                                </center>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>S</th> <!-- Kolom baru untuk S -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $currentPage = $paginate->currentPage();
                                    $perPage = $paginate->perPage();
                                    $no = ($currentPage - 1) * $perPage + 1;
                                    $S_data = [];

                                    // Menghitung nilai S untuk setiap alternatif
                                    foreach ($paginate as $index => $dt) {
                                    $Si = 0;
                                    $criteriaIndex = 0;
                                    foreach ($criteriaColumns as $columnName => $columnLabel) {
                                    // Menghitung Q_ij
                                    $Qij = $V[$index][$criteriaIndex] - $G[$criteriaIndex];
                                    $Si += $Qij; // Menjumlahkan nilai Q_ij untuk mendapatkan S_i
                                    $criteriaIndex++;
                                    }
                                    // Menyimpan hasil perhitungan S dan nama alternatif
                                    $S_data[] = ['nama_umkm' => $dt->nama_umkm, 'Si' => $Si];
                                    }

                                    // Mengurutkan array berdasarkan nilai S secara menurun
                                    usort($S_data, function ($a, $b) {
                                    return $b['Si'] <=> $a['Si'];
                                        });
                                        @endphp

                                        @foreach ($S_data as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data['nama_umkm'] }}</td>
                                            <td>{{ $data['Si'] }}</td> <!-- Menampilkan nilai S_i -->
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                @if ($paginate->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $paginate->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                @foreach ($paginate->getUrlRange(1, $paginate->lastPage()) as $page => $url)
                                @if ($page == $paginate->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach

                                @if ($paginate->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $paginate->nextPageUrl() }}" rel="next">&raquo;</a></li>
                                @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div><br> <br>
</div>
</div>
</div>
</section>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#hasil_perankingan").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "searching": false,
            "info": false,
            "buttons": ["print"],
        }).buttons().container().appendTo('#hasil_perankingan_wrapper .col-md-6:eq(0)');

        $('#hasil_perankingan_wrapper .col-md-6:eq(0)').removeClass('col-md-6').addClass('col-md-12 d-flex justify-content-end');
    });
</script>
@endsection