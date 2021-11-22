<?php

namespace App\Http\Controllers;

use App\Http\Resources\KriteriaResource;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\NilaiResource;
use App\Models\Kriteria;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Validation\Rule;

class NilaiController extends Controller
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
        $kriterias = function (){
            return Kriteria::get();
        };
        $data = Nilai::with('kriteria')->get();
        return Inertia::render('Nilai/Index', [
            'nilais' => $data, 
            'kriterias' => $kriterias,
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
            'kriteria_id' => 'required',
            'nilai_bawah' => 'required|integer|min:0|max:100',
            'nilai_atas' => 'required|integer|min:0|max:100',
            'keterangan' => 'required|string',
        ]);        
        $nilai = new Nilai();
        $nilai->kriteria_id = $request->kriteria_id;
        $nilai->nilai_bawah = $request->nilai_bawah;
        $nilai->nilai_atas = $request->nilai_atas;
        $nilai->keterangan = $request->keterangan;

        $nilai->save();

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function show(Nilai $nilai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function edit(Nilai $nilai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kriteria_id' => 'required',
            'nilai_bawah' => 'required|numeric|min:0|max:100',
            'nilai_atas' => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string',
        ]);                
        $nilai = Nilai::findOrFail($id);
        $nilai->kriteria_id = $request->kriteria_id;
        $nilai->nilai_bawah = $request->nilai_bawah;
        $nilai->nilai_atas = $request->nilai_atas;
        $nilai->keterangan = $request->keterangan;

        $nilai->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nilai  $nilai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();
        return redirect()->back();
    }
}
