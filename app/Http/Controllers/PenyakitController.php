<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\PenyakitGejala;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Penyakit::orderBy('created_at' , 'DESC')->get();

        return view('admin.penyakit.index' , compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gejala = Gejala::where('status' , 'Aktif')->get();
        return view('admin.penyakit.create', compact('gejala'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->gejala);

        $penyakit = new Penyakit;
        $penyakit->nama_penyakit = $request->nama;
        $penyakit->status = 'Aktif';
        $penyakit->save();

        // dd($penyakit);

        foreach ($request->gejala as $item) {
            $gejala = PenyakitGejala::create([
                'id_penyakit' => $penyakit->id,
                'id_gejala' => $item,
            ]);
        }

         return redirect()->route('penyakit.index')->with('toast_success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function show(Penyakit $penyakit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyakit $penyakit)
    {
        $data = $penyakit;
        $gejalaPenyakit = PenyakitGejala::where('id_penyakit' , $data->id)->get();
        $gejala = Gejala::all();

        foreach ($gejalaPenyakit as $item) {
            $gejalaId[] = $item->id;
        }

        return view('admin.penyakit.edit' , compact('data' , 'gejala' , 'gejalaId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyakit $penyakit)
    {
        $penyakit->nama_penyakit = $request->nama;
        $penyakit->status = $request->status;  
        $penyakit->save();

        PenyakitGejala::where('id_penyakit' , $penyakit->id)->delete();

        foreach ($request->gejala as $item) {
            $gejala = PenyakitGejala::create([
                'id_penyakit' => $penyakit->id,
                'id_gejala' => $item,
            ]);
        }

        return redirect()->route('penyakit.index')->with('toast_success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyakit  $penyakit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyakit $penyakit)
    {
        //
    }
}
