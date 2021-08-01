<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Imports\PartImport;
use App\Exports\PartExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $part = Part::all();

        return view('admin.sparePart.index', compact('part'));
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
         // $file = $request->file('file')->store('import');
         // dd($request->file);
        Excel::import(new PartImport, $request->file('file'));

        return redirect()->route('sparepart.index')->with('toast_success', 'Data Berhasil diupload!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        Part::truncate();

        return redirect()->route('sparepart.index')->with('toast_success', 'Data Berhasil dibersihkan!');
    }


    public function exportExcel()
    {
        return Excel::download(new PartExport, 'template-sparepart.xlsx');
    }
}
