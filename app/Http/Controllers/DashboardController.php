<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BookingTime;
use App\Models\Booking;
use App\Models\Part;
use App\Models\Service;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $adminAktif = User::where('status' , 'Aktif')->where('role' , '!=' ,'Customer Service')->count();
         $adminTidakAktif = User::where('status' , 'Tidak Aktif')->where('role' , '!=' ,'Customer Service')->count();

         $CustomerServiceAktif = User::whereStatus('Aktif')->where('role' ,'Customer Service')->count();
         $CustomerServiceTidakAktif = User::whereStatus('Tidak Aktif')->where('role' ,'Customer Service')->count();

         $bookingTime = count(BookingTime::all());
         $booking = Booking::where('booking_date' , Carbon::now())->count();

         $part = Part::first();
         $countPart = count(Part::all());
         if ($countPart = 0) {
            $part = 0;
         }

         $service = Service::first();
         $countService = count(Service::all());
         if ($countService = 0) {
            $part = 0;
         }


        return view('admin.dashboard.index', compact('adminAktif','adminTidakAktif','CustomerServiceAktif' , 'CustomerServiceTidakAktif' , 'bookingTime' , 'booking' , 'part' , 'countPart' , 'service', 'countService'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
