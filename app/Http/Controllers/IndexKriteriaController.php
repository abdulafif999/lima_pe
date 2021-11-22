<?php

namespace App\Http\Controllers;

use App\Models\IndexKriteria;
use App\Models\Kriteria;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexKriteria = IndexKriteria::all();
        $kriterias = Kriteria::all();
        return Inertia::render('IndexKriteria/Index', [
            'indexKriterias' => $indexKriteria,
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
            'periode_awal'=> 'required|date',
            'periode_akhir'=> 'required|date',
            'kriteria.*' => 'required',
            'singleKriteria.*' => 'required',
            'singleIndex.*' => 'required',
            'sub_kriteria.*' => 'nullable',
            'index.*' => 'required|numeric|between:0.01,1.00'
        ]); 

        $periode_awal = $request->periode_awal;
        $periode_akhir = $request->periode_akhir;
        $kriteria = $request->kriteria;
        $sub_kriteria = $request->sub_kriteria;
        $index = $request->index;
        $singleKriteria = $request->singleKriteria;
        $singleIndex = $request->singleIndex;

        $x = 0;
        foreach($singleKriteria as $row){
            IndexKriteria::create([
                'periode_awal' => $periode_awal,
                'periode_akhir' => $periode_akhir,
                'kriteria' => $row,
                'sub_kriteria' => '',
                'index' => (double)$singleIndex[$x],

            ]);
            $x++;
        }

        $n = 0;
        foreach ($kriteria as $row) {
            
            IndexKriteria::create([
                'periode_awal' => $periode_awal,
                'periode_akhir' => $periode_akhir,
                'kriteria' => $row,
                'sub_kriteria' => $sub_kriteria[$n],
                'index' => (double)$index[$n],
            ]);
            $n++;
        } 

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */
    public function show(IndexKriteria $indexKriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */
    public function edit(IndexKriteria $indexKriteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $indexKriteria = IndexKriteria::findOrFail($id);
        $indexKriteria->index = $request->index;

        $indexKriteria->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indexKriteria = IndexKriteria::findOrFail($id);
        $delete = IndexKriteria::where('periode_awal', '=', $indexKriteria->periode_awal)->where('periode_akhir', '=', $indexKriteria->periode_akhir);
        $delete->delete();

        return redirect()->route('indexKriteria.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */    

    public function multiUpdate(Request $request){

        $indexKriteria = IndexKriteria::findOrFail($request->id);
        $values = [
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ];
        $update = IndexKriteria::where('periode_awal', '=', $indexKriteria->periode_awal)->where('periode_akhir', '=', $indexKriteria->periode_akhir);
        $update->update($values);

        return redirect()->route('indexKriteria.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IndexKriteria  $indexKriteria
     * @return \Illuminate\Http\Response
     */


}
