<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Karyawan;
use App\Models\Tim;
use App\Models\TimUnit;
use App\Models\UnitDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }    
    public function index()
    {
        $karyawans = Karyawan::all();
        $data = TimUnit::all();
        $dataUnitDetails = UnitDetail::with('timUnit', 'karyawan')->get();
        return Inertia::render('TimUnit/Index', [
            'timUnits' => $data, 
            'unitDetails' => $dataUnitDetails,
            'karyawans' => $karyawans
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
            'nama' => 'required|string|unique:tim_units',
            'unit' => 'required|string',
            'kategori' => 'required',
        ]);         
        $timUnit = new TimUnit();
        $timUnit->nama = $request->nama;
        $timUnit->unit = $request->unit;
        $timUnit->kategori = $request->kategori;

        $timUnit->save();

        return redirect()->route('unitDetail.index', ['tim_unit_id' => $timUnit->id, 'nama' => $timUnit->nama]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimUnit  $timUnit
     * @return \Illuminate\Http\Response
     */
    public function show(TimUnit $timUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimUnit  $timUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(TimUnit $timUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimUnit  $timUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $timUnit = TimUnit::findOrFail($id);
        $timUnit->nama = $request->nama;
        $timUnit->unit = $request->unit;
        $timUnit->kategori = $request->kategori;

        $timUnit->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimUnit  $timUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timUnit = TimUnit::findOrFail($id);
        $timUnit->delete();
        return redirect()->back();
    }
}
