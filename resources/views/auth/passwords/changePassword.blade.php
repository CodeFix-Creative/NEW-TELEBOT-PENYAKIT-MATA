@extends('layouts.template')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Ubah Password</h2>
        </div>
        {{-- <div class="ml-md-auto py-2 py-md-0">
            <a href="#" data-toggle="modal" data-target="#tambahdata"
                class="btn btn-secondary btn-round button-shadow">Tambah Data</a>
        </div> --}}
    </div>
</div>
@endsection

@section('content')
<div class="row mt--2">
    <!-- Statistic -->
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body ">
                <div class="col-md-12 mt-3">
                    <form action="{{ route('change_password.update') }}" method="POST">
                     @csrf
                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password_lama"
                                    placeholder="Password Lama Anda" name="password_lama">
                                <div class="input-group-append">
                                    <a class="input-group-text btn btn-primary text-white" id="pass-eye-old">
                                        <i class="far fa-eye-slash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_baru">Password Baru</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password_baru"
                                    placeholder="Password Baru Anda" name="password_baru">
                                <div class="input-group-append">
                                    <a class="input-group-text btn btn-primary text-white" id="pass-eye-new">
                                        <i class="far fa-eye-slash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password_baru">Confirm Password Baru</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="confirm_password_baru"
                                    placeholder="Password Baru Anda" name="confirm_password_baru">
                                <div class="input-group-append">
                                    <a class="input-group-text btn btn-primary text-white" id="pass-eye-conf">
                                        <i class="far fa-eye-slash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('bottom')
<script>
    $('#basic-datatables').DataTable();

    $('#pass-eye-old').on('click',function(){
         var input = $("#password_lama");
         if (input.attr("type") === "password") {
            input.attr("type", "text");
         } else {
            input.attr("type", "password");
         }
    });

    $('#pass-eye-new').on('click',function(){
         var input = $("#password_baru");
         if (input.attr("type") === "password") {
            input.attr("type", "text");
         } else {
            input.attr("type", "password");
         }
    });

    $('#pass-eye-conf').on('click',function(){
         var input = $("#confirm_password_baru");
         if (input.attr("type") === "password") {
            input.attr("type", "text");
         } else {
            input.attr("type", "password");
         }
    })

</script>
@endpush
