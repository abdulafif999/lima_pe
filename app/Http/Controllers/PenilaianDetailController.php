<?php

namespace App\Http\Controllers;

use App\Charts\BarChart;
use App\Charts\PenilaianDetailChart;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\User;
use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenilaianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kriteria = Kriteria::all();
        $data = PenilaianDetail::with('penilaian','kriteria')->get();
        $dataPenilians = Penilaian::with('karyawan','timUnit')->get();
        $nilais = Nilai::with('kriteria')->get();
        return Inertia::render('Penilaian/Partials/CreatePenilaianDetail', [
            'penilaianDetails' => $data, 
            'kriterias' => $kriteria,
            'penilaians' => $request,
            'dataPenilaians' =>$dataPenilians,
            'nilais' => $nilais

        ]);
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nilai.*' => 'required|integer|min:0|max:100',
            'status.*' => 'nullable',
            'rekomendasi.*' => 'nullable',
            'foto.*' => 'nullable'
        ]);
        $penilaian = $request->penilaian_id;
        $kriteria = $request->kriteria;
        $nilai = $request->nilai;
        $foto = $request->foto;
        $status = $request->status;
        $rekomendasi = $request->rekomendasi;
        $n = 0;
        foreach ($kriteria as $row) {
            PenilaianDetail::create([
                'penilaian_id' => $penilaian,
                'kriteria_id' => $row,
                'nilai' => $nilai[$n],
                'status' => $status[$n],
                'rekomendasi' => $rekomendasi[$n],
                'foto' => $foto[$n],
            ]);
            $n++;
        }
        return redirect()->route('penilaian.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenilaianDetail  $penilaianDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PenilaianDetail $penilaianDetail, Request $request, BarChart $chartPenilaian)
    {

    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\PenilaianDetail  $penilaianDetail
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(PenilaianDetail $penilaianDetail)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\PenilaianDetail  $penilaianDetail
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, PenilaianDetail $penilaianDetail)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\PenilaianDetail  $penilaianDetail
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(PenilaianDetail $penilaianDetail)
    // {
    //     //
    // }
}
