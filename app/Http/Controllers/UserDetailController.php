<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userDetail = User::with('userDetail')->makeHidden(['created_at', 'updated_at'])->get();

        return response()->json([
            'data' => $userDetail,
            'message' => 'Data retrieved successfully'
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

        // return  $request;
        $request->validate([
            'user_id' => 'required',
            // 'keluarga_id' => 'required',
            // 'nik' => 'required',
            // 'nama_panggilan' => 'required',
            // 'nama_lengkap' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'agama' => 'required',
            // 'alamat' => 'required',
        ]);

        DB::beginTransaction();

        try {

            // save user first
            $user = User::find($request->user_id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->password = bcrypt($request->password);
            // $user->save();

            //  assign role to user
            $user->roles()->updateOrCreate([
                'role' => 'user'
            ]);


            $userDetail = new UserDetail();
            $userDetail->user_id = $user->id;
            $userDetail->keluarga_id = $request->keluarga_id;
            $userDetail->nik = $request->nik;
            $userDetail->nama_panggilan = $request->nama_panggilan;
            $userDetail->nama_lengkap = $request->nama_lengkap;
            $userDetail->tempat_lahir = $request->tempat_lahir;
            $userDetail->tanggal_lahir = $request->tanggal_lahir;
            $userDetail->jenis_kelamin = $request->jenis_kelamin;
            $userDetail->agama = $request->agama;
            $userDetail->alamat = $request->alamat;
            $userDetail->save();

            DB::commit();

            return response()->json([
                'data' => [
                    'user' => $user,
                    'userDetail' => $userDetail
                ],
                'message' => 'Data saved successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data save failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserDetail $userDetail)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserDetail $userDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserDetail $userDetail)
    {
        $request->validate([
            // 'user_id' => 'required',
            // 'keluarga_id' => 'required',
            // 'nik' => 'required',
            // 'nama_panggilan' => 'required',
            // 'nama_lengkap' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'agama' => 'required',
            // 'alamat' => 'required',
        ]); 

        DB::beginTransaction();

        try {
            // // update user first
            // $user = User::find($user->id);
            // if(!$user){
            //     return response()->json([
            //         'message' => 'User not found'
            //     ], 404);
            // }
            // // $user->name = $request->name;
            // // $user->email = $request->email;
            // // // $user->password = $request->password;
            // // $user->save();

            // // update user detail
            $user = User::find($userDetail->user_id);
            $userDetail = UserDetail::find($userDetail->id);
            $userDetail->keluarga_id = $request->keluarga_id;
            $userDetail->nik = $request->nik;
            $userDetail->nama_panggilan = $request->nama_panggilan;
            $userDetail->nama_lengkap = $request->nama_lengkap;
            $userDetail->tempat_lahir = $request->tempat_lahir;
            $userDetail->tanggal_lahir = $request->tanggal_lahir;
            $userDetail->jenis_kelamin = $request->jenis_kelamin;
            $userDetail->agama = $request->agama;
            $userDetail->alamat = $request->alamat;
            $userDetail->save();

            DB::commit();

            return response()->json([
                'data' => [
                    'user' => $user,
                    'userDetail' => $userDetail
                ],
                'message' => 'Data updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDetail $userDetail)
    {
        DB::beginTransaction();

        try {
            $userDetail = UserDetail::where('user_id', $userDetail->id)->first();
            $userDetail->delete();

            $user = User::find($userDetail->user_id);
            // $user->delete();

            DB::commit();

            return response()->json([
                // 'data' => $userDetail,
                'message' => 'Data for user ' . $user->name . ' deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data delete failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
