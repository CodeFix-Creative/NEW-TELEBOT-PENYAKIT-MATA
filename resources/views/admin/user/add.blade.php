@extends('layouts.template')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Tambah User</h2>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt--2">
    <div class="col-md-12">
        <div class="card full-height">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="card-title">Tambah User Baru</div>
                    <div class="card-category mb-3">Silahkan isi form berikut.</div>

                    <div class="form-group">
                        <label for="nama">Nama User</label>
                        <div class="col-md-12 p-0">
                            <input name="nama" id="nama" type="text" class="form-control input-full" placeholder="Masukkan nama User..." value="{{ old('nama') }}">
                            @error('nama')
                            <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telp">No Telp</label>
                        <div class="col-md-12 p-0">
                            <input name="no_telp" type="text" class="form-control input-full" placeholder="Masukkan No telp..." value="{{ old('no_telp') }}">
                            @error('no_telp')
                            <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inlineinput">Jenis Kelamin</label>
                        <div class="col-md-12 p-0">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input @if(old('jk') == 'Laki-laki') {{ 'checked' }} @endif type="radio" class="form-check-input" name="jk" value="Laki-laki">Laki-laki
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input @if(old('jk') == 'Perempuan') {{ 'checked' }} @endif type="radio" class="form-check-input" name="jk" value="Perempuan">Perempuan
                                </label>
                            </div>
                            <div class="form-check-inline">
                            @error('jk')
                                <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inlineinput">Alamat</label>
                        <div class="col-md-12 p-0">
                            <input name="alamat" type="text" class="form-control input-full" placeholder="Masukkan alamat..." value="{{ old('alamat') }}">
                            @error('alamat')
                                <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inlineinput">Email</label>
                        <div class="col-md-12 p-0">
                            <input type="text" name="email" class="form-control input-full" placeholder="Masukkan email..." value="{{ old('email') }}">
                            @error('email')
                                <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inlineinput">Password</label>
                        <div class="col-md-12 p-0">
                            <input name="password" type="password" class="form-control input-full" placeholder="Masukkan password..." value="{{ old('password') }}">
                            @error('password')
                                <small class="form-text text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="card-action text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('bottom')
<script>
$(document).ready(function() {
    //
});
</script>
@endpush
