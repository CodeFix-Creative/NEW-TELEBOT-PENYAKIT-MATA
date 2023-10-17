@extends('layouts.template')

@section('record' , 'active')

@section('content')
<div class="section-header">
    <h1>Record Diagnosa</h1>
    <div class="section-header-breadcrumb">
        
    </div>
</div>

<div class="section-body">
    {{-- Title --}}
    <h2 class="section-title">Data Record Diagnosa</h2>


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
                                    <th>Nama Pasien</th>
                                    <th>Chat Id</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telephone</th>
                                    <th>Record Gejala</th>
                                    <th>Diagnosa Penyakit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $data->nama }}</td>
                                    <td>
                                      @if ($data->chat_id == null)
                                      -
                                      @else
                                      {{ $data->chat_id }}
                                      @endif
                                    </td>
                                    <td>{{ $data->umur }}</td>
                                    <td>{{ $data->jenis_kelamin }}</td>
                                    <td>{{ $data->nomor_telephone }}</td>
                                    <td>
                                      <ul>
                                        @foreach (json_decode($data->record_gejala) as $item)
                                          <li>{{ $item }}</li>
                                        @endforeach
                                      </ul>
                                    </td>
                                    <td>
                                      <ul>
                                        @foreach (json_decode($data->record_penyakit) as $key => $value)
                                          <li>{{ $key }} : {{ $value }}</li>
                                        @endforeach
                                      </ul>
                                    </td>
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
