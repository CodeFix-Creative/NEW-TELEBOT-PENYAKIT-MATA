<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::all();
        $adminAktif = User::whereStatus('Aktif')->where('role' , '!=' , 'Customer Service')->get();
        $adminTidakAktif = User::whereStatus('Tidak Aktif')->where('role' , '!=' , 'Customer Service')->get();
        return view('admin.user.index', compact('adminAktif' , 'adminTidakAktif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
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
         $user->password = bcrypt('Admin123');
         $user->remember_token = Str::random(60);
         $user->role = $request->role;
         $user->status = 'Aktif' ;
         $user->save();

         return redirect()->route('user.index')->with('toast_success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(/* User */ $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(/* User */ $user)
    {
        $user = (object) [
            'id' => 1,
            'nama' => 'User',
            'no_telp' => '081222333444',
            'jk' => 'Laki-laki',
            'alamat' => 'Denpasar',
        ];

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         // dd($request->all());
         $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
         ]);

         return redirect()->route('user.index')->with('toast_success', 'Admin berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(/* User */ $user)
    {
        // $user->update(['status_user' => 0]);

        return redirect()
            ->route('user.index')
            ->with([
                'message' => 'Data berhasil dihapus.', 
                'status' => 'success'
            ]);
    }
}
