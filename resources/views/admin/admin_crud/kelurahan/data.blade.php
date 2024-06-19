@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data UMKM</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/kelurahan">Data Kelurahan</a></li>
                        <li class="breadcrumb-item active">Data UMKM</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama UMKM</th>
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
                                        <td>{{$dt -> laba_bersih}}</td>
                                        <td>{{$dt -> omset}}</td>
                                        <td>{{$dt -> jumlah_karyawan}}</td>
                                        <td>{{$dt -> modal}}</td>
                                        <td>{{$dt -> usia}}</td>
                                        <td>{{$dt -> lokasi}}</td>
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
            <div class="row">
                <div class="col-12 text-center mt-4">
                    <a href="{{ route('data.hitung', $kelurahan_id) }}" class="btn btn-success">Count</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
