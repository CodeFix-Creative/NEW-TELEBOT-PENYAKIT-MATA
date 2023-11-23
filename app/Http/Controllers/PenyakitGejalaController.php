<?php

namespace App\Http\Controllers;

use App\Models\PenyakitGejala;
use App\Models\Penyakit;
use App\Models\Gejala;
use Illuminate\Http\Request;

class PenyakitGejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = PenyakitGejala::orderBy('created_at' , 'DESC')->get();

        return view('admin.penyakitGejala.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penyakit = Penyakit::where('status' , 'Aktif')->orderBy('nama_penyakit' , 'ASC')->get();
        $gejala = Gejala::where('status' , 'Aktif')->orderBy('nama_gejala' , 'ASC')->get();

        return view('admin.penyakitGejala.create' , compact('penyakit', 'gejala'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $gejala = PenyakitGejala::create([
            'id_penyakit' => $request->id_penyakit,
            'id_gejala' => $request->id_gejala,
            'bobot' => $request->bobot,
            'status' => $request->status,
         ]);

         return redirect()->route('penyakit-gejala.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenyakitGejala  $penyakitGejala
     * @return \Illuminate\Http\Response
     */
    public function show(PenyakitGejala $penyakitGejala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenyakitGejala  $penyakitGejala
     * @return \Illuminate\Http\Response
     */
    public function edit(PenyakitGejala $penyakitGejala)
    {
        $data = $penyakitGejala;
        $penyakit = Penyakit::where('status' , 'Aktif')->orderBy('nama_penyakit' , 'ASC')->get();
        $gejala = Gejala::where('status' , 'Aktif')->orderBy('nama_gejala' , 'ASC')->get();

        return view('admin.penyakitGejala.edit' , compact('data', 'penyakit' , 'gejala'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenyakitGejala  $penyakitGejala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenyakitGejala $penyakitGejala)
    {
        $penyakitGejala->id_gejala = $request->id_gejala;
        $penyakitGejala->id_penyakit = $request->id_penyakit;
        $penyakitGejala->bobot = $request->bobot;
        $penyakitGejala->save();

        return redirect()->route('penyakit-gejala.index')->with('toast_success' , 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenyakitGejala  $penyakitGejala
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenyakitGejala $penyakitGejala)
    {
        //
    }
}
