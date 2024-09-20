<?php

namespace App\Http\Controllers;

use App\Models\NutritionLogSetting;
use Illuminate\Http\Request;

class NutritionLogSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $data = NutritionLogSetting::all()->makeHidden(['created_at', 'updated_at']);

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
            'activity' => 'required',
            'description' => 'required',
            // 'active' => 'required',
        ]);

        $nutritionLogSetting = new NutritionLogSetting();
        $nutritionLogSetting->activity = $request->activity;
        $nutritionLogSetting->description = $request->description;
        $nutritionLogSetting->active = $request->active ?? true;

        if (!$nutritionLogSetting->save()) {
            return response()->json([
                'message' => 'Failed to save data'
            ], 500);
        }

        return response()->json([
            'data' => $nutritionLogSetting,
            'message' => 'Data saved successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(NutritionLogSetting $nutritionLogSetting)
    {
        $data  = NutritionLogSetting::find($nutritionLogSetting->id)->makeHidden(['created_at', 'updated_at']);
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NutritionLogSetting $nutritionLogSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NutritionLogSetting $nutritionLogSetting)
    {
        $request->validate([
            'activity' => 'required',
            'description' => 'required',
            // 'active' => 'required',
        ]);

        $nutritionLogSetting  = NutritionLogSetting::find($nutritionLogSetting->id);
        $nutritionLogSetting->activity = $request->activity;
        $nutritionLogSetting->description = $request->description;
        $nutritionLogSetting->active = $request->active ?? true;

 
        if (!$nutritionLogSetting->save()) {
            return response()->json([
                'message' => 'Failed to update data'
            ], 500);
        }

        return response()->json([
            'data' => $nutritionLogSetting,
            'message' => 'Data updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NutritionLogSetting $nutritionLogSetting)
    {
        if (!$nutritionLogSetting->delete()) {
            return response()->json([
                'message' => 'Failed to delete data'
            ], 500);
        }

        return response()->json([
            'message' => 'Data deleted successfully'
        ], 200);
    }
}
