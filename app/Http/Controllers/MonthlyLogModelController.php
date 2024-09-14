<?php

namespace App\Http\Controllers;

use App\Models\MonthlyLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonthlyLogModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $month = $request->get('month');
        $year = $request->get('year');
        $page = $request->get('page') ?? 1;
        $perPage = $request->get('per_page') ?? 10;

        if (Auth::user()->hasRole('admin')) {
            $monthlyLog = MonthlyLogModel::where('month', $month)->where('year', $year)->get();
        } else {
            $monthlyLog = MonthlyLogModel::where('month', $month)->where('year', $year)->where('user_id', Auth::user()->id)->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => paginate($monthlyLog, $page, $perPage)
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
            'tanggal' => 'required',
            // 'hba1c' => 'required',
            // 'sgot' => 'required',
            // 'sgpt' => 'required',
            // 'd_dimer' => 'required',
            // 'ureum' => 'required',
            // 'creatinin' => 'required',
            // 'gfr' => 'required',
            // 'lainnya' => 'required',
            // 'foto' => 'required',
        ]);

        $monthlyLog = new MonthlyLogModel();
        $monthlyLog->user_id = Auth::user()->id;
        $monthlyLog->tanggal = $request->tanggal;
        $monthlyLog->hba1c = $request->hba1c;
        $monthlyLog->sgot = $request->sgot;
        $monthlyLog->sgpt = $request->sgpt;
        $monthlyLog->d_dimer = $request->d_dimer;
        $monthlyLog->ureum = $request->ureum;
        $monthlyLog->creatinin = $request->creatinin;
        $monthlyLog->gfr = $request->gfr;
        $monthlyLog->lainnya = $request->lainnya;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileName = generateUniqueFileName($foto);
            $foto->storeAs('monthly_log', $fileName, 'public');
            $monthlyLog->foto = 'monthly_log/' . $fileName;
        }

        try {
            $monthlyLog->save();
            return response()->json([
                'status' => 'success',
                'data' => $monthlyLog
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save monthly log',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MonthlyLogModel $monthlyLogModel)
    {
        try {
            $monthlyLog = MonthlyLogModel::findOrfail($monthlyLogModel->id);
            return response()->json([
                'status' => 'success',
                'data' => $monthlyLog
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Monthly log not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthlyLogModel $monthlyLogModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonthlyLogModel $monthlyLogModel)
    {

        $request->validate([
            'tanggal' => 'required',
            // 'hba1c' => 'required',
            // 'sgot' => 'required',
            // 'sgpt' => 'required',
            // 'd_dimer' => 'required',
            // 'ureum' => 'required',
            // 'creatinin' => 'required',
            // 'gfr' => 'required',
            // 'lainnya' => 'required',
            // 'foto' => 'required',
        ]);

        $monthlyLog = MonthlyLogModel::find($monthlyLogModel->id);
        $monthlyLog->user_id = Auth::user()->id;
        $monthlyLog->tanggal = $request->tanggal;
        $monthlyLog->hba1c = $request->hba1c;
        $monthlyLog->sgot = $request->sgot;
        $monthlyLog->sgpt = $request->sgpt;
        $monthlyLog->d_dimer = $request->d_dimer;
        $monthlyLog->ureum = $request->ureum;
        $monthlyLog->creatinin = $request->creatinin;
        $monthlyLog->gfr = $request->gfr;
        $monthlyLog->lainnya = $request->lainnya;

        if ($request->hasFile('foto')) {
            // Remove the existing file if it exists
            if ($monthlyLog->foto && Storage::disk('public')->exists($monthlyLog->foto)) {
                Storage::disk('public')->delete($monthlyLog->foto);
            }

            $foto = $request->file('foto');
            $fileName = generateUniqueFileName($foto);
            $foto->storeAs('monthly_log', $fileName, 'public');
            $monthlyLog->foto = 'monthly_log/' . $fileName;
        }

        try {
            $monthlyLog->save();
            return response()->json([
                'status' => 'success',
                'data' => $monthlyLog
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update monthly log',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthlyLogModel $monthlyLogModel)
    {
        $monthlyLog = MonthlyLogModel::find($monthlyLogModel->id);

        if ($monthlyLog->foto && Storage::disk('public')->exists($monthlyLog->foto)) {
            Storage::disk('public')->delete($monthlyLog->foto);
        }

        try {
            $monthlyLog->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Monthly log deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete monthly log',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
