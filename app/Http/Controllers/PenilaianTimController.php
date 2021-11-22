<?php

namespace App\Http\Controllers;

use App\Models\PenilaianTim;
use Illuminate\Http\Request;

class PenilaianTimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'tim_id' => 'required',
            'tim_unit_id' => 'required',
        ]);                
        $tim = $request->tim_id;
        $timUnit = $request->tim_unit_id;
        foreach ($timUnit as $row) {
            
            PenilaianTim::create([
                'tim_id' => $tim,
                'tim_unit_id' => $row
            ]);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenilaianTim  $penilaianTim
     * @return \Illuminate\Http\Response
     */
    public function show(PenilaianTim $penilaianTim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenilaianTim  $penilaianTim
     * @return \Illuminate\Http\Response
     */
    public function edit(PenilaianTim $penilaianTim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenilaianTim  $penilaianTim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenilaianTim $penilaianTim)
    {
        $penilaianTim->tim_id = $request->tim_id;
        $penilaianTim->tim_unit_id = $request->tim_unit_id;
        $penilaianTim->save();

        return redirect()->back();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenilaianTim  $penilaianTim
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenilaianTim $penilaianTim)
    {
        $penilaianTim->delete();
        return redirect()->back();
    }
}
