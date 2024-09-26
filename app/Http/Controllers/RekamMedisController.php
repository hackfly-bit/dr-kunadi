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

        // cek user.userdetail.keluarga  = ayah 
        $user = User::with('userDetail.keluarga')->where('id', $request->user_id)->first();
        $keluargaName = $user->userDetail->keluarga->nama;

        if (!$keluargaName) {
            return response()->json([
                'status' => 'error',
                'message' => 'User Detail belum diisi'
            ], 403);
        }

        if (strtolower($keluargaName) == strtolower('Ayah')) {
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

        // user_id nomer_kk rekam_medis
        $get_existing_rekam_medis = RekamMedis::where('nomer_kk', $request->nomer_kk)->first();

        if (!$get_existing_rekam_medis) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomer RM dengan nomer KK ' . $request->nomer_kk . ' tidak ditemukan'
            ], 404);
        }

        $rekamMedis = RekamMedis::create([
            'user_id' => $request->user_id,
            'no_rekam_medis' => $get_existing_rekam_medis->no_rekam_medis,
            'nomer_kk' => $request->nomer_kk
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $rekamMedis
        ], 200);
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
        $rekamMedis = RekamMedis::with('user.userDetail.keluarga')->where('nomer_kk', $request->nomer_kk)->get();

        // return $rekamMedis['user']['user_detail']['keluarga']['nama'];

        foreach ($rekamMedis as $rm) {
            if ($request->user_id == $rm['user']['id']) {
                if (strtolower($rm['user']->userDetail->keluarga->nama) == strtolower('Ayah')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Cannot update record for Ayah'
                    ], 403);
                }

                $rekamMedis->update([
                    'user_id' => $request->user_id,
                    'no_rekam_medis' => $rm->no_rekam_medis,
                    'nomer_kk' => $request->nomer_kk
                ]);
            }
        }



        return response()->json([
            'status' => 'success',
            'data' => $rekamMedis
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        $rekamMedis->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rekam Medis deleted successfully'
        ], 200);
    }

    private function generateNoRekamMedis($noKK)
    {
        $shortKK = substr($noKK, -5);
        $randomString = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
        $noRekamMedis = 'RM' . $shortKK . $randomString;

        return $noRekamMedis;
    }
}
