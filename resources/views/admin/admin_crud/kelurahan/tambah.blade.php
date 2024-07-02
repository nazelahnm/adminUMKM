@extends('admin.layout.master')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Data Kelurahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                        <li class="breadcrumb-item active">Tambah Data Kelurahan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title" style="text-align: center;">Tambah Data Kelurahan</h3>
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('kelurahan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tahun_id" id="tahun_id" value="{{ $tahun_id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Kelurahan</label>
                                    <select class="form-control" id="nama_kelurahan" name="nama_kelurahan">
                                        <option value="">Pilih Kelurahan</option>
                                        <option value="Balongsari">Balongsari</option>
                                        <option value="Blooto">Blooto</option>
                                        <option value="Gedongan">Gedongan</option>
                                        <option value="Gunung Gedangan">Gunung Gedangan</option>
                                        <option value="Jagalan">Jagalan</option>
                                        <option value="Kauman">Kauman</option>
                                        <option value="Kedundung">Kedundung</option>
                                        <option value="Kranggan">Kranggan</option>
                                        <option value="Magersari">Magersari</option>
                                        <option value="Meri">Meri</option>
                                        <option value="Miji">Miji</option>
                                        <option value="Mentikan">Mentikan</option>
                                        <option value="Prajuritkulon">Prajuritkulon</option>
                                        <option value="Pulorejo">Pulorejo</option>
                                        <option value="Purwotengah">Purwotengah</option>
                                        <option value="Sentanan">Sentanan</option>
                                        <option value="Surodinawan">Surodinawan</option>
                                        <option value="Wates">Wates</option>
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
