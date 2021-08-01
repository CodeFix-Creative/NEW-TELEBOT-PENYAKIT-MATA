<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::all();
        $CustomerServiceAktif = User::whereStatus('Aktif')->where('role' ,'Customer Service')->get();
        $CustomerServiceTidakAktif = User::whereStatus('Tidak Aktif')->where('role' ,'Customer Service')->get();
        return view('admin.customerService.index', compact('CustomerServiceAktif' , 'CustomerServiceTidakAktif'));
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
         $user = new User;
         $user->nama = $request->nama;
         $user->email = $request->email;
         $user->password = bcrypt('CustomerService123');
         $user->remember_token = Str::random(60);
         $user->role = 'Customer Service';
         $user->status = 'Aktif' ;
         $user->save();

         $customerService = new CustomerService;
         $customerService->users_id = $user->id;
         $customerService->customer_service = $request->nama;
         $customerService->save();
         
         return redirect()->route('customerservice.index')->with('toast_success', 'Customer Service Berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerService  $customerService
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerService $customerService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerService  $customerService
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerService $customerService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerService  $customerService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customerService)
    {
         $user = user::where('id' , $customerService)->first();
         // dd($user);

         User::where('id' , $customerService)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'status' => $request->status,
         ]);

         CustomerService::where('users_id' , $user->id)->update([
            'customer_service' =>$request->nama,
         ]);

         return redirect()->route('customerservice.index')->with('toast_success', 'Customer Service Berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerService  $customerService
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerService $customerService)
    {
        //
    }
}
