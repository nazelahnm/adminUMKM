@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Kelurahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('kelurahan.index', ['tahun_id' => $kelurahan->tahun_id])}}">Data Kelurahan</a></li>
                        <li class="breadcrumb-item active">Edit Data Kelurahan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title" style="text-align: center;">Edit Data Kelurahan</h3>
                        </div>
                        <!-- form start -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{route('kelurahan.update', $kelurahan->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Kelurahan</label>
                                    <select class="form-control" id="nama_kelurahan" name="nama_kelurahan">
                                        <option value="">Pilih Kelurahan</option>
                                        <option value="Balongsari" {{ $kelurahan->nama_kelurahan == 'Balongsari' ? 'selected' : '' }}>Balongsari</option>
                                        <option value="Blooto" {{ $kelurahan->nama_kelurahan == 'Blooto' ? 'selected' : '' }}>Blooto</option>
                                        <option value="Gedongan" {{ $kelurahan->nama_kelurahan == 'Gedongan' ? 'selected' : '' }}>Gedongan</option>
                                        <option value="Gunung Gedangan" {{ $kelurahan->nama_kelurahan == 'Gunung Gedangan' ? 'selected' : '' }}>Gunung Gedangan</option>
                                        <option value="Jagalan" {{ $kelurahan->nama_kelurahan == 'Jagalan' ? 'selected' : '' }}>Jagalan</option>
                                        <option value="Kauman" {{ $kelurahan->nama_kelurahan == 'Kauman' ? 'selected' : '' }}>Kauman</option>
                                        <option value="Kedundung" {{ $kelurahan->nama_kelurahan == 'Kedundung' ? 'selected' : '' }}>Kedundung</option>
                                        <option value="Kranggan" {{ $kelurahan->nama_kelurahan == 'Kranggan' ? 'selected' : '' }}>Kranggan</option>
                                        <option value="Magersari" {{ $kelurahan->nama_kelurahan == 'Magersari' ? 'selected' : '' }}>Magersari</option>
                                        <option value="Meri" {{ $kelurahan->nama_kelurahan == 'Meri' ? 'selected' : '' }}>Meri</option>
                                        <option value="Miji" {{ $kelurahan->nama_kelurahan == 'Miji' ? 'selected' : '' }}>Miji</option>
                                        <option value="Mentikan" {{ $kelurahan->nama_kelurahan == 'Mentikan' ? 'selected' : '' }}>Mentikan</option>
                                        <option value="Prajuritkulon" {{ $kelurahan->nama_kelurahan == 'Prajuritkulon' ? 'selected' : '' }}>Prajuritkulon</option>
                                        <option value="Pulorejo" {{ $kelurahan->nama_kelurahan == 'Pulorejo' ? 'selected' : '' }}>Pulorejo</option>
                                        <option value="Purwotengah" {{ $kelurahan->nama_kelurahan == 'Purwotengah' ? 'selected' : '' }}>Purwotengah</option>
                                        <option value="Sentanan" {{ $kelurahan->nama_kelurahan == 'Sentanan' ? 'selected' : '' }}>Sentanan</option>
                                        <option value="Surodinawan" {{ $kelurahan->nama_kelurahan == 'Surodinawan' ? 'selected' : '' }}>Surodinawan</option>
                                        <option value="Wates" {{ $kelurahan->nama_kelurahan == 'Wates' ? 'selected' : '' }}>Wates</option>
                                    </select>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
