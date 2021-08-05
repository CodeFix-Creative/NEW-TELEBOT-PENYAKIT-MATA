<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminAktif = User::where('status' , 'Aktif')->where('role' , '!=' ,'Customer Service')->get();
        $adminTidakAktif = User::where('status' , 'Tidak Aktif')->where('role' , '!=' ,'Customer Service')->get();

        return view('admin.admin.index', compact('adminAktif','adminTidakAktif'));
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
      //  dd($request->all());
        $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:users',
            'role' => 'required',
        ]);

        // dd($request->all());
         $user = new User;
         $user->nama = $request->nama;
         $user->email = $request->email;
         $user->password = 'Admin123';
         $user->remember_token = Str::random(40);
         $user->role = $request->role;
         $user->status = 'Aktif' ;
         $user->save();

         return redirect()->route('admin.index')->with('toast_success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $admin)
    {
      //  dd($admin);
        $request->validate([
            'nama' => 'required',
            'email' => 'required_unless:email,' . $admin->email,
            'status' => 'required',
            'role' => 'required',
        ]);

        $cekEmail = User::where('id', '!=', $admin->id)->where('email', $request->email)->first();

        if($cekEmail) {
            return redirect()->back()->withInput()->with('toast_error', 'Email yang akan diubah telah digunakan. Silahkan gunakan email lain.');
        }

         $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
         ]);

         return redirect()->route('admin.index')->with('toast_success', 'Admin berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
