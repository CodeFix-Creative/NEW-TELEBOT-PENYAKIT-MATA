@extends('layouts.template')

@section('manual' , 'active')


@section('content')
<div class="section-header">
    {{-- <div class="section-header-back">
        <a href="{{ route('penyakit.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div> --}}
    <h1>Hasil Diagnosa</h1>
</div>

<div class="section-body">
    <h2 class="section-title">Hasil Diagnosa Tanpa Chatbot</h2>
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
                                <p>{{ $nama }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Umur Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <p>{{ $umur }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">jenis Kelamin Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <p>{{ $jenis_kelamin }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Telephone Pasien</label>
                            <div class="col-sm-12 col-md-7">
                                <p>{{ $nomor_telephone }}</p>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gejala</label>
                            <div class="col-sm-12 col-md-7">
                                <ul>
                                    @foreach ($record_gejala as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diagnosa Penyakit</label>
                            <div class="col-sm-12 col-md-7">
                                <ul>
                                  @foreach ($record_penyakit as $key => $value)
                                      <li>{{ $key }} : {{ $value }}</li>
                                  @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
