<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppInfoResource;
use App\Models\AppInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppInfoController extends Controller
{
    
    public function store(Request $request){
        $user_id = Auth::user()->id;
        $data = AppInfo::first();
        if(!isset($data)) {
            $data = new AppInfo();
            $data->user_id = $user_id;
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->created_at = now();
            $data->updated_at = now();
            $data->save();
            /*  */
            return response()->json([
                'status' => 1,
                'message' => 'Data successfully saved.',
                'data' => new AppInfoResource($data),
            ]);
        }
        $data->user_id = $user_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->description = $request->description;
        $data->updated_at = now();
        $data->save();
        /*  */
        return response()->json([
            'status' => 1,
            'message' => 'Data successfully saved.',
            'data' => new AppInfoResource($data),
        ]);
    }

    public function view(){
        $data = AppInfo::with(['user'])->first();
        if(!isset($data)) {
            return response()->json([
                'data' => ''
            ]);
        }
        return new AppInfoResource($data);
       
    }


}
