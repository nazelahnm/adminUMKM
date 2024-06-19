@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Kriteria</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Data Kriteria</li>
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
                        <!-- <div class="card-header">
                            <a class="btn btn-primary" href="{{ route('kriteria.create') }}">Tambah Kriteria</a>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kriteria</th>
                                        <th>Bobot</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginate as $index => $ktr)
                                    <tr>
                                        <th scope="row">{{$paginate->firstItem() + $index}}</th>
                                        <td>{{$ktr -> kriteria}}</td>
                                        <td>{{$ktr -> bobot}}</td>
                                        <td>{{$ktr -> jenis}}</td>
                                        <td>{{$ktr -> keterangan}}</td>
                                        <td class="text-center">
                                            <form action="{{route('kriteria.edit',$ktr->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <a class="btn btn-warning" href="{{route('kriteria.edit',$ktr->id)}}"><i class="fas fa-edit"></i></a>
                                            </form>
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

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection