<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\PenyakitGejala;
use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gejala = Gejala::where('status' , 'Aktif')->get();
        return view('admin.diagnosa.index', compact('gejala'));
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
        // $totalGejala = count($request->gejala);

        // $penyakitGejala = null;
        // $idPenyakit = [];
        // $diagnosaPenyakit = [];
        // $diagnosaGejala = [];

        // foreach ($request->gejala as $idGejala) {
        //     $data = PenyakitGejala::where('id_gejala' , $idGejala)->get();

        //     foreach ($data as $item) {
        //         if (!in_array($item->id_penyakit, $idPenyakit)) {
        //             $idPenyakit[] = $item->id_penyakit;
        //         }

        //         $penyakitGejala[] = $item->id_penyakit;
        //     }

        //     // Record Gejala
        //     $gejala = Gejala::find($idGejala);
        //     $diagnosaGejala[] = $gejala->nama_gejala;
        // }

        // $probPenyakit = array_count_values($penyakitGejala);

        // foreach ($probPenyakit as $key => $value) {
        //     $persentase = ($value / $totalGejala) * 100;
        //     $probPenyakit[$key] = round($persentase);
        // }

        // foreach ($probPenyakit as $key => $value) {
        //    $penyakit = Penyakit::where('id' , $key)->first();
        //    $diagnosaPenyakit[$penyakit->nama_penyakit] = $value."%";
        // }

        // $diagnosa = new Diagnosa;
        // $diagnosa->nama = $request->nama;
        // $diagnosa->umur = $request->umur;
        // $diagnosa->jenis_kelamin = $request->jenis_kelamin;
        // $diagnosa->nomor_telephone = $request->nomor_telephone;
        // $diagnosa->record_gejala = json_encode($diagnosaGejala);
        // $diagnosa->record_penyakit = json_encode($diagnosaPenyakit);
        // $diagnosa->save();
        
        $diagnosaGejala = [];
        
        foreach ($request->gejala as $idGejala) {
            $penyakitGejala = PenyakitGejala::where('id_gejala' , $idGejala)->get();
            $gejala = Gejala::where('id' , $idGejala)->first();

            $diagnosaGejala[] = $gejala->nama_gejala;

            $diagnosaPenyakit = [];

            $jumlahAtas = 0;
            $jumlahBawah = 0;

            // Hitungan Bawah Selalu Sama
            foreach ($penyakitGejala as $data) {
                $jumlahBawah += $data->bobot * $data->penyakit->score;
            }

            // Hitungan Atas
            foreach ($penyakitGejala as $data) {
                $jumlahAtas = $data->bobot * $data->penyakit->score;
                $totalBagi = round($jumlahAtas / $jumlahBawah , 3);

                $diagnosaPenyakit[] = [
                    'id_penyakit' => $data->penyakit->id,
                    'total_probabilitas' => $totalBagi,
                    'persentase' => $totalBagi * 100,
                ];
            }

            $diagnosaPenyakitFinal = [];

            // Check Penyakit Paling Tinggi
            $persentaseTertinggi = 0;
            foreach ($diagnosaPenyakit as $data) {

              if($data['persentase'] > $persentaseTertinggi){
                  $persentaseTertinggi = $data['persentase'];
                  $diagnosaPenyakitFinal = [
                      'id_penyakit' => $data['id_penyakit'],
                      'total_probabilitas' => $data['total_probabilitas'],
                      'persentase' => $data['persentase'],
                  ]; 
              }
            }

            
          }
        
        $diagnosa = new Diagnosa;
        $diagnosa->nama = $request->nama;
        $diagnosa->umur = $request->umur;
        $diagnosa->jenis_kelamin = $request->jenis_kelamin;
        $diagnosa->nomor_telephone = $request->nomor_telephone;
        $diagnosa->record_gejala = json_encode($diagnosaGejala);
        $diagnosa->record_penyakit = json_encode($diagnosaPenyakitFinal);
        $diagnosa->save();


        return view('admin.diagnosa.output' , 
        [
          'nama' => $request->nama , 
          'umur' => $request->umur , 
          'nomor_telephone' => $request->nomor_telephone , 
          'jenis_kelamin' => $request->jenis_kelamin , 
          'record_gejala' => $diagnosaGejala ,
          'record_penyakit' => $diagnosaPenyakitFinal ,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnosa $diagnosa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diagnosa  $diagnosa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnosa $diagnosa)
    {
        //
    }


    public function recordDiagnosa()
    {
        $datas = Diagnosa::orderBy('created_at' , 'DESC')->get();
        return view('admin.record.index', compact('datas'));
    }
}
