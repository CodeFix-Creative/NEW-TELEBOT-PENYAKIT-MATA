@extends('layouts.template')

@section('penyakit-gejala' , 'active')

@section('content')
<div class="section-header">
    <h1>Penyakit Gejala</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('penyakit-gejala.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Penyakit Gejala</h2>


    {{-- Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Penyakit</th>
                                    <th>Nama Gejala</th>
                                    <th>Bobot</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->penyakit->nama_penyakit }}</td>
                                    <td>{{ $data->gejala->nama_gejala }}</td>
                                    <td>{{ $data->bobot }}</td>
                                    <td><a href="{{ route('penyakit-gejala.edit' , $data->id) }}" class="btn btn-warning">Ubah</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
