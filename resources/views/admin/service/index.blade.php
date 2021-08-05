@extends('layouts.template')

@section('service' , 'active')

@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Service Status</h2>
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
                    <a href="#!" class="text-white">Data Status Servis Asus Service Center</a>
                </li>
            </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
            <a href="#" data-toggle="modal" data-target="#tambahdata"
                class="btn btn-success btn-round button-shadow mr-3"><i class="fas fa-upload" title="Edit"></i> Upload Data</a>
            <a href="{{ route('serviceExcel') }}" class="btn btn-secondary btn-round button-shadow mr-3"><i class="fas fa-download" title="Edit"></i> Download Template</a>
            {{-- <a href="#" class="btn btn-danger btn-round button-shadow delete"><i class="fas fa-trash-alt" title="Edit"></i> Clear Data</a> --}}
            <form id="delete-user-form" action="{{route('service.destroy', '1')}}" method="POST" class="d-inline">
               @csrf
               @method('DELETE')
               <button onclick="return false" id="delete-user" class="btn btn-danger btn-round button-shadow delete"><i class="fas fa-trash-alt" title="Edit"></i> Clear Data</button>
            </form>
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
                        <table id="basic-datatables" class="basic-datatables display table table-striped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width:1px;white-space:nowrap;">No</th>
                                    <th style="width:1px;white-space:nowrap;">RMA NO 1</th>
                                    <th style="width:1px;white-space:nowrap;">RMA ISSUE DATE</th>
                                    <th style="width:1px;white-space:nowrap;">SERIAL NO</th>
                                    <th style="width:1px;white-space:nowrap;">MODEL ID</th>
                                    <th style="width:1px;white-space:nowrap;">PRODUCT TYPE DESC</th>
                                    <th style="width:1px;white-space:nowrap;">STATUS 1</th>
                                    <th style="width:1px;white-space:nowrap;">TRANSFER SHIP SUBMIT DATE</th>
                                    <th style="width:1px;white-space:nowrap;">RMA NO 1 FINAL TEST DATE</th>
                                    <th style="width:1px;white-space:nowrap;">WARRANTY END</th>
                                    <th style="width:1px;white-space:nowrap;">WARRANTY STATUS</th>
                                    <th style="width:1px;white-space:nowrap;">RMA CENTER 2</th>
                                    <th style="width:1px;white-space:nowrap;">RMA NO 2</th>
                                    <th style="width:1px;white-space:nowrap;">STATUS 2</th>
                                    <th style="width:1px;white-space:nowrap;">KBO STATUS</th>
                                    <th style="width:1px;white-space:nowrap;">ORDER DATE</th>
                                    <th style="width:1px;white-space:nowrap;">ALLOCATED DATE</th>
                                    <th style="width:1px;white-space:nowrap;">KBO ETA END</th>
                                    <th style="width:1px;white-space:nowrap;">ORG PART DESC</th>
                                    <th style="width:1px;white-space:nowrap;">NEW PART NO</th>
                                    <th style="width:1px;white-space:nowrap;">NEW PART DESC</th>
                                    <th style="width:1px;white-space:nowrap;">FINAL RMA STATUS</th>
                                    <th style="width:1px;white-space:nowrap;">REMARK / PROBLEM</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>RMA NO 1</th>
                                    <th>RMA ISSUE DATE</th>
                                    <th>SERIAL NO</th>
                                    <th>MODEL ID</th>
                                    <th>PRODUCT TYPE DESC</th>
                                    <th>STATUS 1</th>
                                    <th>TRANSFER SHIP SUBMIT DATE</th>
                                    <th>RMA NO 1 FINAL TEST DATE</th>
                                    <th>WARRANTY END</th>
                                    <th>WARRANTY STATUS</th>
                                    <th>RMA CENTER 2</th>
                                    <th>RMA NO 2</th>
                                    <th>STATUS 2</th>
                                    <th>KBO STATUS</th>
                                    <th>ORDER DATE</th>
                                    <th>ALLOCATED DATE</th>
                                    <th>KBO ETA END</th>
                                    <th>ORG PART DESC</th>
                                    <th>NEW PART NO</th>
                                    <th>NEW PART DESC</th>
                                    <th>FINAL RMA STATUS</th>
                                    <th>REMARK / PROBLEM</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @php
                                $nomor = 1;
                                @endphp
                                @foreach($service as $service)
                                <tr>
                                    <td>{{ $nomor }}</td>
                                    <td >{{ $service->rma_no_1 }}</td>
                                    <td >{{ $service->rma_issue_date }}</td>
                                    <td >{{ $service->serial_no }}</td>
                                    <td >{{ $service->model_id }}</td>
                                    <td >{{ $service->product_type_desc }}</td>
                                    <td >{{ $service->status_1 }}</td>
                                    <td >{{ $service->transfer_ship_submit_date }}</td>
                                    <td >{{ $service->rma_no_1_finaltest_date }}</td>
                                    <td >{{ $service->warranty_end }}</td>
                                    <td >{{ $service->warranty_status }}</td>
                                    <td >{{ $service->rma_center_2 }}</td>
                                    <td >{{ $service->rma_no_2 }}</td>
                                    <td >{{ $service->status_2 }}</td>
                                    <td >{{ $service->kbo_status }}</td>
                                    <td >{{ $service->order_date }}</td>
                                    <td >{{ $service->allocated_date }}</td>
                                    <td >{{ $service->kbo_eta_end }}</td>
                                    <td >{{ $service->org_part_desc }}</td>
                                    <td >{{ $service->new_part_no }}</td>
                                    <td >{{ $service->new_part_desc }}</td>
                                    <td style="width:1px;white-space:nowrap;">{{ $service->final_rma_status }}</td>
                                    <td >{{ $service->remark_or_problem }}</td>
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
                <h5 class="modal-title" id="tabahdatalabel">Upload Data Excel Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('service.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama -->
                    <div class="form-group">
                        <label for="nama">Upload File Excel</label>
                        <input type="file" class="form-control" id="booking_time" placeholder="Booking Time (00:00 - 00:00)"
                            name="file" required>
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


@endsection

@push('bottom')
<script>
    $('.basic-datatables').DataTable();
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

    $('#delete-user').on('click', function () {
      //   var id_kandidat = $(this).attr("id-kandidat");
      //   console.log(id_kandidat);
         event.preventDefault();
         let id = $(this).data('id');

        Swal.fire({
            title: "Apa anda yakin ?",
            text: "Ingin menghapus seluruh data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            console.log(result.value)
            if(result.value){
                $('#delete-user-form').submit(); 
            }else{
                Swal.fire("Dibatalkan!", "data batal di hapus :)", "error");
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
