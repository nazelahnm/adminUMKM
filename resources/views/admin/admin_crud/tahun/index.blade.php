@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data UMKM Tiap Tahun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Data Tahun</li>
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
                        <div class="card-header">
                            <a class="btn btn-primary" href="{{ route('tahuns.create') }}">Tambah Tahun</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tahun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginate as $thn)
                                    <tr>
                                        <td>{{$thn -> id}}</td>
                                        <td>{{$thn -> year}}</td>
                                        <td class="text-center">
                                            <form action="{{route('tahuns.edit',$thn->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <a class="btn btn-warning" href="{{route('tahuns.edit',$thn->id)}}"><i class="fas fa-edit"></i></a>
                                            </form>
                                            
                                            <form action="{{route('tahuns.destroy',$thn->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah anda yakin hapus data ini ? ')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>

                                            <form action="{{route('kelurahan.show',$thn->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <a class="btn btn-success" href="{{route('kelurahan.show',$thn->id)}}">Lihat Data Kelurahan</a>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection