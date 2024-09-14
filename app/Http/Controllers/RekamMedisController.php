<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Models\User;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // rekam_medis, nutritionLog,monthlyLog,dailyLog

        $log = [
            'nutrition_log'  => 'nutritionLog',
            'monthly_log' => 'monthlyLog',
            'daily_log' => 'dailyLog'
        ];
        $get_record = $request->get('record') ?? 'rekam_medis';

        if ($get_record == 'rekam_medis') {
            $rekamMedis = User::with('rekamMedis')->get();
        } else {
            $rekamMedis = User::with($log[$get_record])->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $rekamMedis
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            // 'no_rekam_medis' => 'required',
            'nomer_kk' => 'required'
        ]);

        $noRekamMedis = $this->generateNoRekamMedis($request->nomer_kk);

        // make sure the no_rekam_medis is unique
        while (RekamMedis::where('no_rekam_medis', $noRekamMedis)->exists()) {
            $noRekamMedis = $this->generateNoRekamMedis($request->nomer_kk);
        }

        try {
            $rekamMedis = RekamMedis::create([
                'user_id' => $request->user_id,
                'no_rekam_medis' => $noRekamMedis,
                'nomer_kk' => $request->nomer_kk
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $rekamMedis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $rekamMedis)
    {
        $rekamMedis = User::with(['rekamMedis', 'nutritionLog', 'monthlyLog', 'dailyLog'])->where('id', $rekamMedis->id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $rekamMedis
        ], 200);
    }

    public function showByNoRekamMedis($noRekamMedis)
    {
        $rekamMedis = User::with(['rekamMedis', 'nutritionLog', 'monthlyLog', 'dailyLog'])->where('no_rekam_medis', $noRekamMedis)->all();

        return response()->json([
            'status' => 'success',
            'data' => $rekamMedis
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekamMedis $rekamMedis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $rekamMedis = RekamMedis::find($rekamMedis->id);
        $rekamMedis->nomer_kk = $request->nomer_kk; // update nomer_kk

        try {
            $rekamMedis->save();

            return response()->json([
                'status' => 'success',
                'data' => $rekamMedis
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        
    }

    private function generateNoRekamMedis($noKK)
    {
        $shortKK = substr($noKK, -5);
        $randomString = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $noRekamMedis = 'RM' . $shortKK . $randomString;

        return $noRekamMedis;
    }
}
