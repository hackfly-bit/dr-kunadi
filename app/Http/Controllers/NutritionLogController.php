<?php

namespace App\Http\Controllers;

use App\Models\NutritionGroup;
use App\Models\NutritionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NutritionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $startDate = $request->start_date ?? date('Y-m-d', strtotime('-1 day'));
        $endDate = $request->end_date ?? date('Y-m-d');
        if(Auth::user()->hasRole('admin')){
            $data = NutritionGroup::with('nutritionLogs')->whereBetween('tanggal', [$startDate, $endDate])->get()->makeHidden(['created_at', 'updated_at']);
        }else{
            $data = NutritionGroup::with('nutritionLogs')->where('user_id', Auth::user()->id)->whereBetween('tanggal', [$startDate, $endDate])->get()->makeHidden(['created_at', 'updated_at']);
        }

        return response()->json(paginate($data,$page, $per_page), 200);
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
        ]);

      DB::beginTransaction();
        try {
            $nutritionGroup = NutritionGroup::create([
            'user_id' => Auth::user()->id,
            'tanggal' => $request->tanggal,
            ]);

            $nutritionLogRequest = $request->nutrition_logs;
            foreach ($nutritionLogRequest as $key => $value) {
            $nutritionLog = NutritionLog::create([
                'nutrition_group_id' => $nutritionGroup->id,
                'nutrition_log_setting_id' => $value['nutrition_log_setting_id'],
                'status' => $value['status'],
            ]);
            }

          DB::commit();
        } catch (\Exception $e) {
          DB::rollBack();
            return response()->json(['error' => 'Failed to store nutrition logs.'], 500);
        }

        return response()->json(['message' => 'Nutrition logs stored successfully.'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionGroup $nutritionGroup)
    {
        $nutritionGroup = NutritionGroup::with('nutritionLogs')->find($nutritionGroup->id);

        return response()->json($nutritionGroup, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NutritionLog $nutritionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);
    
        DB::beginTransaction();
        try {
            // Find the existing NutritionGroup by ID
            $nutritionGroup = NutritionGroup::findOrFail($id);
    
            // Update NutritionGroup data
            $nutritionGroup->update([
                'user_id' => Auth::user()->id,
                'tanggal' => $request->tanggal,
            ]);
    
            // Process nutrition_logs in request
            $nutritionLogRequest = $request->nutrition_logs;
    
            foreach ($nutritionLogRequest as $key => $value) {
                // Check if a NutritionLog exists with the same group and setting ID
                $nutritionLog = NutritionLog::where('nutrition_group_id', $nutritionGroup->id)
                                            ->where('nutrition_log_setting_id', $value['nutrition_log_setting_id'])
                                            ->first();
    
                if ($nutritionLog) {
                    // Update existing log
                    $nutritionLog->update([
                        'status' => $value['status'],
                    ]);
                } else {
                    // Create new log if it doesn't exist
                    NutritionLog::create([
                        'nutrition_group_id' => $nutritionGroup->id,
                        'nutrition_log_setting_id' => $value['nutrition_log_setting_id'],
                        'status' => $value['status'],
                    ]);
                }
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Nutrition logs updated successfully.'], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update nutrition logs.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionGroup $nutritionGroup)
    {
        $nutritionGroup->delete();

        return response()->json(['message' => 'Nutrition logs deleted successfully.'], 200);
    }
}
