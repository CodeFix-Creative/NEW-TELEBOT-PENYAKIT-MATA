@extends('layouts.template')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Booking Time</h2>
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
                    <a href="#!" class="text-white">Data Waktu Booking yang Tersedia di Asus Service Center</a>
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
                    <div class="table-responsive">
                        <table id="basic-datatables" class="basic-datatables display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th class="text-center">Booking Time</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th class="text-center">Booking Time</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                $nomor = 1;
                                @endphp
                                @foreach($bookingTime as $bookingTime)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td class="text-center">{{ $bookingTime->booking_time }} WITA</td>
                                    <td>
                                        <a href="#!" class="btn btn-success btn-sm ubah-data float-left rounded"
                                            data-toggle="modal" data-target="#editdata" data-id="{{ $bookingTime->id }}"
                                            data-booking-time="{{ $bookingTime->booking_time }}" ><i class="far fa-edit" title="Edit"></i>
                                        </a>
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


<!-- Modal Tambah-->
<div class="modal fade bd-example-modal-lg" id="tambahdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Tambah Daftar Booking Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('bookingtime.store') }}" method="post">
                    @csrf

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama">Booking Time</label>
                        <input type="text" class="form-control" id="booking_time" placeholder="Booking Time (00:00 - 00:00)"
                            name="booking_time" value="00:00 - 00:00" required>
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
                <h5 class="modal-title" id="tabahdatalabel">Ubah Data Booking Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- FORM -->
            <form id="edit-form" action="{{ route('bookingtime.update', '') }}" method="post"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PUT')
                    @csrf

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama">Booking Time</label>
                        <input type="text" class="form-control" id="edit-booking_time" placeholder="Booking Time (00:00 - 00:00)"
                            name="booking_time" required>
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
        var id = $(this).data('id');
        var bookingTime = $(this).data('booking-time');
        var action = $('#editdata #edit-form').attr('action');
        action += '/' + id;
        // console.log(id_anggota);
        $('#editdata #edit-form').attr('action', action);
        $('#editdata #edit-booking_time').val(bookingTime);

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

    $('#pass-eye').on('click', function () {
        var input = $("#password");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    })

</script>
@endpush
