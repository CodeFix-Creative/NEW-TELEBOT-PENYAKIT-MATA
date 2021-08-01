@extends('layouts.template')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Customer Service</h2>
            <ul class="breadcrumbs text-white ml-0">
                <li class="nav-home">
                    <a href="#!" class="text-white">
                        <i class="flaticon-file"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#!" class="text-white">Data Customer Service Asus Service Center</a>
                </li>
            </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
            <a href="#" data-toggle="modal" data-target="#tambahdata"
                class="btn btn-secondary btn-round button-shadow">Tambah Data</a>
        </div>
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
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="Aktif-tab" data-toggle="tab" href="#Aktif" role="tab"
                                aria-controls="Aktif" aria-selected="true">Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="TidakAktif-tab" data-toggle="tab" href="#TidakAktif" role="tab"
                                aria-controls="TidakAktif" aria-selected="false">Tidak Aktif</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Aktif" role="tabpanel" aria-labelledby="Aktif-tab">
                            <div class="table-responsive">
                                <table id="basic-datatables"
                                    class="basic-datatables display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                        $nomor = 1;
                                        @endphp
                                        @foreach($CustomerServiceAktif as $CustomerService)
                                        <tr>
                                            <td>{{ $nomor }}</td>
                                            <td>{{ $CustomerService->nama }}</td>
                                            <td>{{ $CustomerService->email }}</td>
                                            <td>{{ $CustomerService->role }}</td>
                                            <td><span class="badge badge-success">{{ $CustomerService->status }}</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#!" class="btn btn-success btn-sm ubah-data float-left"
                                                        data-toggle="modal" data-target="#editdata"
                                                        data-id-admin="{{ $CustomerService->id }}" data-nama="{{ $CustomerService->nama }}"
                                                        data-email="{{ $CustomerService->email }}" data-role="{{ $CustomerService->role }}"
                                                        data-status="{{ $CustomerService->status }}"
                                                        data-password="{{ $CustomerService->password }}"><i
                                                            class="far fa-edit"></i>
                                                    </a>
                                                    {{-- <a href="#!" class="btn btn-danger btn-sm ml-2 delete"
                                            style="margin-right: 5px;" id-anggota="{{ $anggota->id }}"><i
                                                        class="far fa-trash-alt"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                        $nomor++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="TidakAktif" role="tabpanel" aria-labelledby="TidakAktif-tab">
                            <div class="table-responsive">
                                <table id="basic-datatables2"
                                    class="basic-datatable display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                        $nomor = 1;
                                        @endphp
                                        @foreach($CustomerServiceTidakAktif as $CustomerService)
                                        <tr>
                                            <td>{{ $nomor }}</td>
                                            <td>{{ $CustomerService->nama }}</td>
                                            <td>{{ $CustomerService->email }}</td>
                                            <td>{{ $CustomerService->role }}</td>
                                            <td><span class="badge badge-danger">{{ $CustomerService->status }}</span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#!" class="btn btn-success btn-sm ubah-data float-left"
                                                        data-toggle="modal" data-target="#editdata"
                                                        data-id-admin="{{ $CustomerService->id }}" data-nama="{{ $CustomerService->nama }}"
                                                        data-email="{{ $CustomerService->email }}" data-role="{{ $CustomerService->role }}"
                                                        data-status="{{ $CustomerService->status }}"
                                                        data-password="{{ $CustomerService->password }}"><i
                                                            class="far fa-edit"></i>
                                                    </a>
                                                    {{-- <a href="#!" class="btn btn-danger btn-sm ml-2 delete"
                                            style="margin-right: 5px;" id-anggota="{{ $anggota->id }}"><i
                                                        class="far fa-trash-alt"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                        $nomor++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah-->
<div class="modal fade bd-example-modal-lg" id="tambahdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Tambah Customer Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('customerservice.store') }}" method="post">
                    @csrf

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Customer Service" name="nama" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Email Customer Service" name="email"
                            required>
                    </div>

            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        </form>
        <!-- /FORM -->
    </div>
</div>
<!-- End Modal Tambah-->

<!-- Modal Edit -->
<div class="modal fade bd-example-modal-lg" id="editdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Ubah Data Customer Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- FORM -->
            <form id="edit-form" action="{{ route('customerservice.update', '') }}" method="post" enctype="multipart/form-data">
            <div class="modal-body">
               @method('PUT')
               @csrf

               <!-- Nama -->
               <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="edit-nama" placeholder="Nama Admin" name="nama" required>
               </div>

               <!-- Email -->
               <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="edit-email" placeholder="Email Admin" name="email" required>
               </div>

               <!-- status -->
               <div class="form-group">
                  <label for="status" class="">Status Admin</label>
                  <select class="custom-select" name="status" id="edit-status">
                        <option selected>-- Status Admin --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            <!-- /FORM -->
         </div>
    </div>
</div>
<!-- End Modal Edit -->

@endsection

@push('bottom')
<script>
    $('#basic-datatables').DataTable();
    $('#basic-datatables2').DataTable();

    // jquery ajax edit data
    $('.ubah-data').on('click', function () {
        var id = $(this).data('id-admin');
        var nama = $(this).data('nama');
        var role = $(this).data('role');
        var email = $(this).data('email');
        var password = $(this).data('password');
        var status = $(this).data('status');
        var action = $('#editdata #edit-form').attr('action');
        action += '/' + id;
        // console.log(id_anggota);
        $('#editdata #edit-form').attr('action', action);
        $('#editdata #edit-nama').val(nama);
        $('#editdata #edit-role').val(role);
        $('#editdata #edit-email').val(email);
        $('#editdata #edit-password').val(password);
        $('#editdata #edit-status').val(status);

    });

    $('.delete').on('click', function () {
        var id = $(this).attr("id-anggota");
        var action = $('#delete-form').attr('action');
        action += '/' + id;

        Swal.fire({
            title: "Apa anda yakin ?",
            text: "Ingin menghapus data barang ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            console.log(result.value)
            if (result.value) {
                // window.location = "/admin/barang/" + id_barang;
                $('#delete-form').attr('action', action);
                $('#delete-form').submit();
            } else {
                Swal.fire("Dibatalkan!", "Data barang batal di hapus :)", "error");
            }
        });
    });

    $('#pass-eye').on('click',function(){
         var input = $("#password");
         if (input.attr("type") === "password") {
            input.attr("type", "text");
         } else {
            input.attr("type", "password");
         }
    })

</script>
@endpush
