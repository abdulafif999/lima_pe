<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\UnitDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitDetailController extends Controller
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
    public function index(Request $request)
    {
        $karyawans = function (){
            return Karyawan::get();
        };
        $data = UnitDetail::with('karyawan','timUnit')->get();
        return Inertia::render('UnitDetail/Partials/CreateUnitDetail', [
            'unitDetails' => $data, 
            'karyawans' => $karyawans,
            'timUnits' => $request
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
            'pernum' => 'required',
            'tim_unit_id' => 'required',
            'posisi' => 'required'
        ]);         
        
        $timUnit = $request->tim_unit_id;
        $pernums = $request->pernum;
        $posisis = $request->posisi;
        $n = 0;
        foreach ($pernums as $row) {
            
            UnitDetail::create([
                'pernum' => $row,
                'tim_unit_id' => $timUnit,
                'posisi' => $posisis[$n]
            ]);
            $n++;
        }
        return redirect()->route('timUnit.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitDetail  $unitDetail
     * @return \Illuminate\Http\Response
     */
    public function show(UnitDetail $unitDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitDetail  $unitDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitDetail $unitDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitDetail  $unitDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitDetail $unitDetail)
    {             
        $unitDetail->tim_unit_id = $request->tim_unit_id;
        $unitDetail->pernum = $request->pernum;
        $unitDetail->posisi = $request->posisi;

        $unitDetail->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitDetail  $unitDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitDetail $unitDetail)
    {
        $unitDetail->delete();
        return redirect()->back();
    }
}
