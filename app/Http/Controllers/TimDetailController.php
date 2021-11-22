<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Tim;
use App\Models\TimDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimDetailController extends Controller
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
        $data = TimDetail::with('tim','karyawan')->get();
        return Inertia::render('TimDetail/Partials/CreateTimDetail', [
            'timDetails' => $data, 
            'tims' => $request,
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
            'tim_id' => 'required',
            'selected.*' => 'required',
            'posisi.*' => 'required|string'
        ]);
        $tim = $request->tim_id;
        $nips = $request->selected;
        $posisis = $request->posisi;
        $n = 0;
        foreach ($nips as $nip) {
            
            TimDetail::create([
                'tim_id' => $tim,
                'nip'    => $nip,
                'posisi' => $posisis[$n]
            ]);
            $n++;
        }
        return redirect()->route('tim.index');
        
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimDetail  $timDetail
     * @return \Illuminate\Http\Response
     */
    public function show(TimDetail $timDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimDetail  $timDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(TimDetail $timDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimDetail  $timDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $timDetail = TimDetail::findOrFail($id);
        $timDetail->tim_id = $request->tim_id;
        $timDetail->nip = $request->selected;
        $timDetail->posisi = $request->posisi;

        $timDetail->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimDetail  $timDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimDetail $timDetail)
    {
        $timDetail->delete();
        return redirect()->back();
    }
    public function destroyAll(TimDetail $timDetail)
    {  
        $timDetail::where('tim_id', $timDetail)->delete();

        return redirect()->back();
    }    
}
