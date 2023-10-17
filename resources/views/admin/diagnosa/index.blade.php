@extends('layouts.template')

@section('manual' , 'active')


@section('content')
<div class="section-header">
    {{-- <div class="section-header-back">
        <a href="{{ route('penyakit.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div> --}}
    <h1>Manual Diagnosa</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Manual Diagnosa Tanpa Chatbot</h2>
    <p class="section-lead">
        Harap isi sesuai aturan
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Diagnosa Pasien</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('diagnosa.store') }}" enctype="multipart/form-data" method="post">
                     @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="nama">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Umur Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="umur">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">jenis Kelamin Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="jenis_kelamin">
                                    <option value="L">Laki - Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Telephone Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="nomor_telephone">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gejala</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" multiple="" name="gejala[]" >
                                    @foreach ($gejala as $gejala)
                                    <option value="{{ $gejala->id }}">{{ $gejala->nama_gejala }}</option>
                                    @endforeach
                                </select>
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
