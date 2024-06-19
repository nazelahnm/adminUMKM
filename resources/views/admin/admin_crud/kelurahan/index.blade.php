@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Kelurahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Data Kelurahan</li>
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
                            <a class="btn btn-primary" href="{{ route('kelurahan.create') }}">Tambah Kelurahan</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kelurahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paginate as $klr)
                                    <tr>
                                        <td>{{$klr -> id}}</td>
                                        <td>{{$klr -> nama_kelurahan}}</td>
                                        <td class="text-center">
                                            <form action="{{route('kelurahan.edit',$klr->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <a class="btn btn-warning" href="{{route('kelurahan.edit',$klr->id)}}"><i class="fas fa-edit"></i></a>
                                            </form>
                                            
                                            <form action="{{route('kelurahan.destroy',$klr->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah anda yakin hapus data ini ? ')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                Import File Excel
                                            </button>


                                            <form action="{{route('data.show',$klr->id)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <a class="btn btn-success" href="{{route('data.show',$klr->id)}}">Lihat Data UMKM</a>
                                            </form>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('data.import') }}" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body" style="text-align: left;">
                                                                {{ csrf_field() }}
                                                                <input class="d-none" name="kelurahan_id" value="{{ $klr->id }}">
                                                                <div class="form-group">
                                                                    <input type="file" name="file" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Import</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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