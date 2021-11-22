<?php

namespace App\Http\Controllers;


use App\Models\Penilaian;
use App\Models\TimDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\PenilaianDetailController;
use App\Models\IndexKriteria;
use App\Models\PenilaianDetail;
use App\Models\PenilaianTim;
use App\Models\UnitDetail;
use App\Models\User;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function index()
    {

        $tims = TimDetail::with('tim','karyawan')->get();
        $penilaianTims = PenilaianTim::with('tim', 'timUnit')->get();
        $data = Penilaian::with('karyawan', 'timUnit')->get();
        $dataDetail = PenilaianDetail::with('kriteria','penilaian')->get();
        $unitDetails = UnitDetail::with('timUnit','karyawan')->get();
        return Inertia::render('Penilaian/Index', [
            'penilaians' => $data, 
            'tims' => $tims,
            'penilaianDetails' => $dataDetail,
            'penilaianTims' => $penilaianTims,
            'unitDetails' => $unitDetails,
        ]);
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
        $request->validate([
            'tgl' => 'required|date',
            'pernum' => 'required',
            'tim_unit_id' => 'required',
            
        ]);                
        $penilaian = new Penilaian();
        $penilaian->tgl = $request->tgl;
        $penilaian->pernum = $request->pernum;
        $penilaian->tim_unit_id= $request->tim_unit_id;

        $penilaian->save();

        return redirect()->route('penilaianDetail.index', [
            'penilaian_id' => $penilaian->id, 
            'pernum' => $penilaian->pernum, 
            'tim_unit_id' => $penilaian->tim_unit_id, 
            'tgl' => $penilaian->tgl
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }
}
