<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * param  int  $page
     * param  int  $per_page
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $data = Keluarga::all()->makeHidden(['created_at', 'updated_at']);
        return response()->json(paginate($data, $page, $per_page), 200);
    }

   

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * param  string  $nama
     * param  string  $deskripsi
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $keluarga = new Keluarga();
        $keluarga->nama = $request->nama;
        $keluarga->deskripsi = $request->deskripsi;

        if (!$keluarga->save()) {
            return response()->json([
                'message' => 'Failed to save data'
            ], 500);
        }

        return response()->json([
            'data' => $keluarga,
            'message' => 'Data saved successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Keluarga  $keluarga  
     * @return \Illuminate\Http\Response
     * 
     */
    public function show(Keluarga $keluarga)
    {
        $keluarga = Keluarga::find($keluarga->id);
        if (!$keluarga) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
        $keluarga->makeHidden(['created_at', 'updated_at']);
        return response()->json([
            'data' => $keluarga
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keluarga $keluarga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keluarga $keluarga)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);
        
       $keluarga = Keluarga::find($keluarga->id);
        if (!$keluarga) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $keluarga->nama = $request->nama;
        $keluarga->deskripsi = $request->deskripsi;

        if (!$keluarga->save()) {
            return response()->json([
                'message' => 'Failed to save data'
            ], 500);
        }

        return response()->json([
            'data' => $keluarga,
            'message' => 'Data updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keluarga $keluarga)
    {
        $keluarga = Keluarga::find($keluarga->id);
        if (!$keluarga) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        if (!$keluarga->delete()) {
            return response()->json([
                'message' => 'Failed to delete data'
            ], 500);
        }

        return response()->json([
            'data' => $keluarga,
            'message' => 'Data deleted successfully'
        ], 200);
    }

}
