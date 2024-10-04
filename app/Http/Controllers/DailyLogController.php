<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class DailyLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $page = $request->get('page') ?? 1;
        $perPage = $request->get('per_page') ?? 10;

        if (Auth::user()->hasRole('admin')) {
            if ($startDate && $endDate) {
                $dailyLogs = DailyLog::whereBetween('date', [$startDate, $endDate])->get();
            } else {
                $dailyLogs = DailyLog::all();
            }
        } else {
            $dailyLogs = DailyLog::where('user_id', Auth::user()->id);
        }

        $status = $dailyLogs->count() > 0 ? 'success' : 'failed';    

        return response()->json(paginate($dailyLogs, $page, $perPage, $status), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            // 'user_id' => 'required',
            'tanggal' => 'required',
            // 'bb' => 'required',
            // 'tb' => 'required',
            // 'lingkar_perut' => 'required',
            // 'denyut_nadi' => 'required',
            // 'tekanan_darah' => 'required',
            // 'gula_darah_sewaktu' => 'required',
            // 'gula_darah_puasa' => 'required',
            // 'asam_urat' => 'required',
            // 'kolesterol' => 'required',
            // 'foto_bb' => 'required',
            // 'foto_lingkar_perut' => 'required',
            // 'foto_tekanan_darah' => 'required',
            // 'foto_gula_darah_sewaktu' => 'required',
            // 'foto_gula_darah_puasa' => 'required',
            // 'foto_asam_urat' => 'required',
            // 'foto_kolesterol' => 'required',
        ]);

        $dailyLog = new DailyLog();
        $dailyLog->user_id = Auth::user()->id;
        $dailyLog->tanggal = $request->tanggal;
        $dailyLog->bb = $request->bb;
        $dailyLog->tb = $request->tb;
        $dailyLog->lingkar_perut = $request->lingkar_perut;
        $dailyLog->denyut_nadi = $request->denyut_nadi;
        $dailyLog->tekanan_darah = $request->tekanan_darah;
        $dailyLog->gula_darah_sewaktu = $request->gula_darah_sewaktu;
        $dailyLog->gula_darah_puasa = $request->gula_darah_puasa;
        $dailyLog->asam_urat = $request->asam_urat;
        $dailyLog->kolesterol = $request->kolesterol;

        // Function to generate unique file names
        if ($request->hasFile('foto_bb')) {
            $dailyLog->foto_bb = $request->file('foto_bb')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_bb')), 'public');
        }
        if ($request->hasFile('foto_lingkar_perut')) {
            $dailyLog->foto_lingkar_perut = $request->file('foto_lingkar_perut')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_lingkar_perut')), 'public');
        }
        if ($request->hasFile('foto_tekanan_darah')) {
            $dailyLog->foto_tekanan_darah = $request->file('foto_tekanan_darah')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_tekanan_darah')), 'public');
        }
        if ($request->hasFile('foto_gula_darah_sewaktu')) {
            $dailyLog->foto_gula_darah_sewaktu = $request->file('foto_gula_darah_sewaktu')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_gula_darah_sewaktu')), 'public');
        }
        if ($request->hasFile('foto_gula_darah_puasa')) {
            $dailyLog->foto_gula_darah_puasa = $request->file('foto_gula_darah_puasa')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_gula_darah_puasa')), 'public');
        }
        if ($request->hasFile('foto_asam_urat')) {
            $dailyLog->foto_asam_urat = $request->file('foto_asam_urat')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_asam_urat')), 'public');
        }
        if ($request->hasFile('foto_kolesterol')) {
            $dailyLog->foto_kolesterol = $request->file('foto_kolesterol')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_kolesterol')), 'public');
        }

        // Save the DailyLog to the database
        $dailyLog->save();

        // Return the response
        return response()->json([
            'status' => 'success',
            'data' => $dailyLog
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the DailyLog entry by ID
        $dailyLog = DailyLog::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $dailyLog
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyLog $dailyLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate required fields
        // return $request;
        $request->validate([
            'tanggal' => 'required',
            // Add other validation as needed
            // 'bb' => 'required',
            // 'tb' => 'required',
            // 'lingkar_perut' => 'required',
            // 'denyut_nadi' => 'required',
            // 'tekanan_darah' => 'required',
            // 'gula_darah_sewaktu' => 'required',
            // 'gula_darah_puasa' => 'required',
            // 'asam_urat' => 'required',
            // 'kolesterol' => 'required',
            // 'foto_bb' => 'required',
            // 'foto_lingkar_perut' => 'required',
            // 'foto_tekanan_darah' => 'required',
            // 'foto_gula_darah_sewaktu' => 'required',
            // 'foto_gula_darah_puasa' => 'required',
            // 'foto_asam_urat' => 'required',
            // 'foto_kolesterol' => 'required',
        ]);

        // Find the DailyLog entry by ID
        $dailyLog = DailyLog::findOrFail($id);

        // Update the fields
        $dailyLog->tanggal = $request->tanggal;
        $dailyLog->bb = $request->bb;
        $dailyLog->tb = $request->tb;
        $dailyLog->lingkar_perut = $request->lingkar_perut;
        $dailyLog->denyut_nadi = $request->denyut_nadi;
        $dailyLog->tekanan_darah = $request->tekanan_darah;
        $dailyLog->gula_darah_sewaktu = $request->gula_darah_sewaktu;
        $dailyLog->gula_darah_puasa = $request->gula_darah_puasa;
        $dailyLog->asam_urat = $request->asam_urat;
        $dailyLog->kolesterol = $request->kolesterol;
        // Helper function to remove old file if new file is uploaded
        function removeOldFile($filePath)
        {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Handle file updates
        if ($request->hasFile('foto_bb')) {
            // Remove the old file
            removeOldFile($dailyLog->foto_bb);
            // Store the new file
            $dailyLog->foto_bb = $request->file('foto_bb')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_bb')), 'public');
        }

        if ($request->hasFile('foto_lingkar_perut')) {
            removeOldFile($dailyLog->foto_lingkar_perut);
            $dailyLog->foto_lingkar_perut = $request->file('foto_lingkar_perut')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_lingkar_perut')), 'public');
        }

        if ($request->hasFile('foto_tekanan_darah')) {
            removeOldFile($dailyLog->foto_tekanan_darah);
            $dailyLog->foto_tekanan_darah = $request->file('foto_tekanan_darah')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_tekanan_darah')), 'public');
        }

        if ($request->hasFile('foto_gula_darah_sewaktu')) {
            removeOldFile($dailyLog->foto_gula_darah_sewaktu);
            $dailyLog->foto_gula_darah_sewaktu = $request->file('foto_gula_darah_sewaktu')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_gula_darah_sewaktu')), 'public');
        }

        if ($request->hasFile('foto_gula_darah_puasa')) {
            removeOldFile($dailyLog->foto_gula_darah_puasa);
            $dailyLog->foto_gula_darah_puasa = $request->file('foto_gula_darah_puasa')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_gula_darah_puasa')), 'public');
        }

        if ($request->hasFile('foto_asam_urat')) {
            removeOldFile($dailyLog->foto_asam_urat);
            $dailyLog->foto_asam_urat = $request->file('foto_asam_urat')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_asam_urat')), 'public');
        }

        if ($request->hasFile('foto_kolesterol')) {
            removeOldFile($dailyLog->foto_kolesterol);
            $dailyLog->foto_kolesterol = $request->file('foto_kolesterol')->storeAs('daily_logs', generateUniqueFileName($request->file('foto_kolesterol')), 'public');
        }

        // Save the updated DailyLog to the database
        $dailyLog->save();

        // Return the response
        return response()->json([
            'status' => 'success',
            'data' => $dailyLog
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyLog $dailyLog)
    {
        // Find the DailyLog entry by ID
        $dailyLog = DailyLog::findOrFail($dailyLog->id);

        // Helper function to remove file
        removeFile($dailyLog->foto_bb);
        removeFile($dailyLog->foto_lingkar_perut);
        removeFile($dailyLog->foto_tekanan_darah);
        removeFile($dailyLog->foto_gula_darah_sewaktu);
        removeFile($dailyLog->foto_gula_darah_puasa);
        removeFile($dailyLog->foto_asam_urat);
        removeFile($dailyLog->foto_kolesterol);

        // Delete the DailyLog entry
        $dailyLog->delete();

        // Return the response
        return response()->json([
            'status' => 'success',
            'message' => 'Daily log deleted successfully'
        ], 200);
    }
}
