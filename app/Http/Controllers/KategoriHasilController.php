<?php

namespace App\Http\Controllers;

use App\Models\KategoriHasil;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KategoriHasilController extends Controller
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
        $data = KategoriHasil::all();
        return Inertia::render('KategoriHasil/Index', ['kategoriHasils' => $data]);
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
            'nilai_atas' => 'required|integer',
            'nilai_bawah' => 'required|integer',
            'nama' => 'required|string',
        ]);
        $kategoriHasil = new KategoriHasil();
        $kategoriHasil->nilai_atas = $request->nilai_atas;
        $kategoriHasil->nilai_bawah = $request->nilai_bawah;
        $kategoriHasil->nama = $request->nama;
        $kategoriHasil->save();

        return redirect()->back()->with('success', 'Kategori Hasil berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriHasil  $kategoriHasil
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriHasil $kategoriHasil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriHasil  $kategoriHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriHasil $kategoriHasil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriHasil  $kategoriHasil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_atas' => 'required|integer',
            'nilai_bawah' => 'required|integer',
            'nama' => 'required|string',
        ]);
        $kategoriHasil = KategoriHasil::findOrFail($id);
        $kategoriHasil->nilai_atas = $request->nilai_atas;
        $kategoriHasil->nilai_bawah = $request->nilai_bawah;
        $kategoriHasil->nama = $request->nama;
        $kategoriHasil->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriHasil  $kategoriHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoriHasil = KategoriHasil::findOrFail($id);
        $kategoriHasil->delete();
        return redirect()->back();
    }
}
