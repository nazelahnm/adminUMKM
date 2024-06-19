@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Proses Perhitungan MABAC</h1>
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
                    <!-- Langkah 1 -->
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
                                        <th scope="row">{{ $paginate->firstItem() + $index }}</th>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        <td>{{ $dt->laba_bersih / 1000000 }}</td>
                                        <td>{{ $dt->omset / 1000000 }}</td>
                                        <td>{{ $dt->jumlah_karyawan }}</td>
                                        <td>{{ $dt->modal / 1000000 }}</td>
                                        <td>{{ $dt->usia }}</td>
                                        <td>{{ $dt->lokasiValue }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                @if ($paginate->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $paginate->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                @foreach ($paginate->getUrlRange(1, $paginate->lastPage()) as $page => $url)
                                @if ($page == $paginate->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                </li>
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

                    <!-- Langkah 2 -->
                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <h6>Langkah 2 (Normalisasi Matriks Keputusan Awal(X))</h6>
                                <thead>
                                    <tr>
                                        <td colspan="2">Nilai Max</td>
                                        @foreach ($maxValues as $maxValue)
                                        <td>{{ intval($maxValue) / 100000 }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td colspan="2">Nilai Min</td>
                                        @foreach ($minValues as $minValue)
                                        <td>{{ intval($minValue) / 100000 }}</td>
                                        @endforeach
                                    </tr>
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
                                        <th scope="row">{{ $paginate->firstItem() + $index }}</th>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        <td>{{ collect($T)->firstWhere('nama_umkm', $dt->nama_umkm)[$columnName] }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                @if ($paginate->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $paginate->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                @foreach ($paginate->getUrlRange(1, $paginate->lastPage()) as $page => $url)
                                @if ($page == $paginate->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                </li>
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

                    <!-- Langkah 3 -->
                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <h6>Langkah 3 (Perhitungan Elemen Matriks Tertimbang (V))</h6>
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
                                        <th scope="row">{{ $paginate->firstItem() + $index }}</th>
                                        <td>{{ $dt->nama_umkm }}</td>
                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        <td>{{ collect($V)->firstWhere('nama_umkm', $dt->nama_umkm)[$columnName] }}
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                @if ($paginate->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $paginate->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                                @endif

                                @foreach ($paginate->getUrlRange(1, $paginate->lastPage()) as $page => $url)
                                @if ($page == $paginate->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                </li>
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

                    <!-- Langkah 4 -->
                    <div class="card" style="display: none;">
                        <div class="card-body">
                            <table id="hasil_mabac" class="table table-bordered text-center">
                                <h6>Langkah 4 (Penentuan Matriks Area Perkiraan Perbatasan (G))</h6>
                                <thead>
                                    <tr>
                                        <th colspan="2"></th>
                                        @foreach ($criteriaColumns as $columnLabel)
                                        <th>{{ $columnLabel }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">Nilai G</td>
                                        @foreach ($G as $G_value)
                                        <td>{{ $G_value }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table><br>
                        </div>
                    </div>

                    <!-- Langkah 5 -->
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
                                    @foreach ($paginate as $index => $dt)
                                    <tr>
                                        <th scope="row">{{ $paginate->firstItem() + $index }}</th>
                                        <td>{{ $dt->nama_umkm }}</td>

                                        @foreach ($criteriaColumns as $columnName => $columnLabel)
                                        <td>{{ collect($V)->firstWhere('nama_umkm', $dt->nama_umkm)["qij_$columnName"] }}
                                        </td>
                                        @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table><br>
                        </div>
                        <!-- pagination -->
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


                    <!-- Langkah 6 -->
                    <div class="card">
                        <div class="card-body">
                            <table id="hasil_perankingan" class="table table-bordered table-hover">
                                <center>
                                    <font size="6">
                                        <b>HASIL PERANKINGAN</b>
                                    </font>
                                </center>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternatif</th>
                                        <th>Si</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($S_data as $index => $S_item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + $offset }}</th>
                                        <td>{{ $S_item['nama_umkm'] }}</td>
                                        <td>{{ $S_item['Si'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination -->
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
    </section>
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
            "searching": true,
            "info": false,
            "buttons": ["print"],
        }).buttons().container().appendTo('#hasil_perankingan_wrapper .col-md-6:eq(0)');

        $('#hasil_perankingan_wrapper .col-md-6:eq(0)').removeClass('col-md-6').addClass('col-md-12 d-flex justify-content-end');
    });
</script>
@endsection