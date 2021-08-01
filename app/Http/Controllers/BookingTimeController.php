<?php

namespace App\Http\Controllers;

use App\Models\BookingTime;
use Illuminate\Http\Request;

class BookingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingTime = BookingTime::all();

        return view('admin.bookingTime.index', compact('bookingTime'));
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
        $validate = $request->validate([
            'booking_time' => 'required',
        ]);

        BookingTime::create($validate);

        return redirect()->route('bookingtime.index')->with('toast_success', 'Booking Time berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function show(BookingTime $bookingTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingTime $bookingTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bookingTime)
    {
      //   dd($bookingTime);
      //   $bookingTime = BookingTime::where('id' , $bookingTime)->first();

        BookingTime::where('id' , $bookingTime)->update([
            'booking_time' => $request->booking_time,
         ]);


        return redirect()->route('bookingtime.index')->with('toast_success', 'Booking Time berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingTime  $bookingTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingTime $bookingTime)
    {
        //
    }
}
