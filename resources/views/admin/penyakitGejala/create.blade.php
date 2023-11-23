@extends('layouts.template')

@section('penyakit-gejala' , 'active')


@section('content')
<div class="section-header">
    <div class="section-header-back">
        <a href="{{ route('penyakit-gejala.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Data</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Data Baru</h2>
    <p class="section-lead">
        Harap isi sesuai aturan
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Penyakit Gejala</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('penyakit-gejala.store') }}" enctype="multipart/form-data" method="post">
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Penyakit</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="id_penyakit">
                                    @foreach ($penyakit as $penyakit)
                                    <option value="{{ $penyakit->id }}">{{ $penyakit->nama_penyakit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gejala</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="id_gejala">
                                    @foreach ($gejala as $gejala)
                                    <option value="{{ $gejala->id }}">{{ $gejala->nama_gejala }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bobot</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="bobot">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
