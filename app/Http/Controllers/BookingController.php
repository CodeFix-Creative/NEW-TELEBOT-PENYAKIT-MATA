<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //   $booking = Booking::where('id_customer_service' , $customerService->id)->where('booking_date' , Carbon::now()->format('Y-m-d'))->get();
      if (Auth::user()->role == 'Customer Service') {
         $customerService = CustomerService::where('users_id' , Auth::user()->id)->first();
         $booking = Booking::where('booking_date' , Carbon::now()->format('Y-m-d'))->where('id_customer_service' , $customerService->id)->get();
      }else {
         $booking = Booking::where('booking_date' , Carbon::now()->format('Y-m-d'))->get();
      }
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('admin.bookingList.index', compact('booking','currentDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function bookingListTanggal(Request $request)
    {
      //  dd($request->all());

       if(Auth::user()->role == 'Super Admin' || Auth::user()->role == 'Admin'){
         $booking = Booking::where('booking_date' , $request->tanggal)->get();
         $currentDate =  $request->tanggal;

         return view('admin.bookingList.index' , compact('booking' , 'currentDate'));

      }if(Auth::user()->role == 'Customer Service'){
         $customerService = CustomerService::where('users_id' , Auth::user()->id)->first();
         $booking = Booking::where('booking_date' , $request->tanggal)->where('id_customer_service' , $customerService->id)->get();
         $currentDate =  $request->tanggal;

         return view('admin.bookingList.index' , compact('booking' , 'currentDate'));
      }
    }

    public function downloadExcel($currentDate)
    {
      //  dd($currentDate);

       return Excel::download(new BookingExport($currentDate), 'Report-Booking-'. $currentDate .'.xlsx');

       
    }

    public function cancelBooking($bookingid , $currentDate)
    {
      //  dd($currentDate);
      $booking = Booking::where('booking_id' , $bookingid)->first();

      $booking->update([
         'status' => 'Cancel'
      ]);

      return redirect()->route('bookingList.index')->with('toast_success', 'Data berhasil diubah!');

      // dd($currentDate);
      

       
    }

    public function doneBooking($bookingid , $currentDate)
    {
      //  dd($currentDate);

      //  dd($bookingid);

      $booking = Booking::where('booking_id' , $bookingid)->first();

      $booking->update([
         'status' => 'Done'
      ]);

      return redirect()->route('bookingList.index')->with('toast_success', 'Data berhasil diubah!');

       
    }
}
