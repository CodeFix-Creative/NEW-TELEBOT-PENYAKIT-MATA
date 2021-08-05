@extends('layouts.template')
@php $dashboard = true @endphp
@section('header')
<div class="page-inner py-5">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
            <h5 class="text-white op-7 mb-2">Selamat datang, <strong>{{ Auth::user()->nama ?? 'Guest' }}</strong></h5>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt--2">
    <!-- Statistic -->
    <div class="col-md-3">
        <div class="card full-height">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-user-cog fa-5x"></i>
                    </div>
                    <div class="col-md-8">
                        <h2>Admin</h2>
                        <h5>Aktif = {{ $adminAktif }} | Tidak Aktif = {{ $adminTidakAktif }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card full-height">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-headset fa-5x"></i>
                    </div>
                    <div class="col-md-8">
                        <h2>Customer Service</h2>
                        <h5>Aktif = {{ $CustomerServiceAktif }} | Tidak Aktif = {{ $CustomerServiceTidakAktif }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card full-height">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-calendar-alt fa-5x"></i>
                    </div>
                    <div class="col-md-8">
                        <h2>Booking Time</h2>
                        <h5>{{ $bookingTime }} Slot Booking untuk setiap CS</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card full-height">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <i class="fas fa-calendar-check fa-5x"></i>
                    </div>
                    <div class="col-md-8">
                        <h2>Booking Hari ini</h2>
                        <h5>{{ $booking }} Client</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt--2">
   <div class="col-md-6">
      <div class="card full-height">
         <div class="card-body text-center">
            <div class="mb-3">
               <i class="fas fa-clipboard-check fa-5x"></i>
            </div>
            <div>
               <h2>Terakhir Update Service</h2>
               <h4>{{ $part }}</h4>
               <h4>Total Data = {{ $countPart }}</h4>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card full-height">
         <div class="card-body text-center">
            <div class="mb-3">
               <i class="fas fa-cogs fa-5x"></i>
            </div>
            <div>
               <h2>Terakhir Update Spare Part</h2>
               <h4>{{ $part->updated_at->translatedFormat('d F Y') }}</h4>
               <h4>Total Data = {{ $countPart }}</h4>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('bottom')
<script>
    $('#basic-datatables').DataTable();

</script>
@endpush
