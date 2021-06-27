@extends('layouts.template')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Data User</h2>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-round mr-2">Tambah User</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt--2">
    @if(session()->has('message'))
    <div class="col-md-12">
        <div class="alert alert-{{ session()->get('status') }}">{{ session()->get('message') }}</div>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- SAMPLE DATA -->
                                <tr>
                                    <td>1</td>
                                    <td>User 1</td>
                                    <td>user@example.com</td>
                                    <td>081222333444</td>
                                    <td>Laki-laki</td>
                                    <td>Aktif</td>
                                    <td>
                                        <div class="btn-group">
                                        <a href="{{ route('user.edit', 1) }}" class="btn btn-warning btn-sm ml-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.destroy', 1) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm ml-2" style="margin-right: 5px;"
                                                onclick="return confirm('Apakah yakin ingin menghapus?');"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @foreach($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->no_telp }}</td>
                                    <td>{{ $item->jk }}</td>
                                    <td>{{ ($item->status_user == 1) ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <div class="btn-group">
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning btn-sm ml-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm ml-2" style="margin-right: 5px;"
                                                onclick="return confirm('Apakah yakin ingin menghapus?');"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                        </div>
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

@push('bottom')
<script>
$(document).ready(function() {
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });

    $('#basic-datatables').DataTable();
});
</script>
@endpush
