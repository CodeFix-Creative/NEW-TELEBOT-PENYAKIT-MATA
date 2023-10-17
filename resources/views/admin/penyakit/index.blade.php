@extends('layouts.template')

@section('penyakit' , 'active')

@section('content')
<div class="section-header">
    <h1>Penyakit</h1>
    <div class="section-header-breadcrumb">
        <div class="section-header-button">
            <a href="{{ route('penyakit.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Penyakit</h2>


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
                                    <th>Gejala</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->nama_penyakit }}</td>
                                    <td>
                                      <ul>
                                        @foreach ($data->gejalaRelations() as $item)
                                          <li>{{ $item->gejala->nama_gejala }}</li>
                                        @endforeach
                                      </ul>
                                    </td>
                                    <td>
                                        @if ($data->status == "Aktif")
                                        <div class="badge badge-success">{{ $data->status }}</div>
                                        @else
                                        <div class="badge badge-danger">{{ $data->status }}</div>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('penyakit.edit' , $data->id) }}" class="btn btn-warning">Ubah</a></td>
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
