<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\TimDetail;
use App\Models\PenilaianTim;
use App\Models\Karyawan;
use App\Models\TimUnit;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimController extends Controller
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
        $data = Tim::all();
        $karyawans = Karyawan::all();
        $timUnits = TimUnit::all();
        $dataTim = TimDetail::with('tim','karyawan')->get();
        $penilaianTim = PenilaianTim::with('tim','timUnit')->get();
        return Inertia::render('Tim/Index', [
            'tims' => $data,
            'dataTims' => $dataTim,
            'karyawans' => $karyawans,
            'penilaianTims' => $penilaianTim,
            'timUnits' => $timUnits
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
            'nama' => 'required|string'
        ]);                
        $tim = new Tim();
        $tim->nama = $request->nama;
        $tim->save();

        return redirect()->route('timDetail.index', ['tim_id' => $tim->id, 'nama' => $tim->nama]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tim  $tim
     * @return \Illuminate\Http\Response
     */
    public function show(Tim $tim)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tim  $tim
     * @return \Illuminate\Http\Response
     */
    public function edit(Tim $tim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tim  $tim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tim = Tim::findOrFail($id);
        $tim->nama = $request->nama;
        $tim->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tim  $tim
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tim = Tim::findOrFail($id);
        $tim->delete();
        return redirect()->back();
    }
}
