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
        return view('auth.passwords.changePassword');
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
         if($request->password_baru == $request->confirm_password_baru){
          if (Hash::check($request->password_lama, Auth::user()->password)) {
             auth()->user()->update([
                'password' => bcrypt($request->password_baru),
             ]);

             return redirect()->route('change_password.index')->with('toast_success', 'Password Anda Berhasil Di Ubah!!');
          }else{
             return back()->with('toast_error', 'Password Lama Anda Tidak Sama !!');
          }
        } else {
            return back()->with('toast_error', 'Confirmasi Password Tidak Sama !!');
        }
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
