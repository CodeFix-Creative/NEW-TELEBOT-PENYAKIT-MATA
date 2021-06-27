<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $user = [];
        return view('admin.user.index', compact('user'));
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
        // $validated = $request->validate(
        //     [
        //         'nama'      => 'required',
        //         'no_telp'   => 'required',
        //         'jk'        => 'required',
        //         'alamat'    => 'required',
        //         'email'     => 'required|email|unique:users',
        //         'password'  => 'required|min:8',
        //         'role'      => 'required',
        //     ]
        // );

        // $validated['status_user'] = 1;
        // $validated['password'] = bcrypt($request->password);

        // $user = User::create($validated);

        return redirect()
            ->route('user.index')
            ->with([
                'message' => 'Data berhasil ditambahkan.', 
                'status' => 'success'
            ]);
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
    public function update(Request $request, /* User */ $user)
    {
        // $validated = $request->validate(
        //     [
        //         'nama'      => 'required',
        //         'no_telp'   => 'required',
        //         'jk'        => 'required',
        //         'alamat'    => 'required',
        //     ]
        // );

        // $user->update($request->only(['nama','no_telp','jk','alamat','status_user']));

        return redirect()
            ->route('user.index')
            ->with([
                'message' => 'Data berhasil diubah.', 
                'status' => 'success'
            ]);
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
