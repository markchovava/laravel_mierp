<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{

    public function indexAll(){
        $data = Role::with(['user'])
                ->orderBy('level', 'asc')
                ->orderBy('updated_at', 'desc')
                ->get();
        return RoleResource::collection($data);
    }

    public function index(){
        $data = Role::with(['user'])
                ->orderBy('level', 'asc')
                ->orderBy('updated_at', 'desc')
                ->paginate(12);
        return RoleResource::collection($data);
    }

    public function search($search){
        $data = Role::with(['user'])
                ->orderBy('level', 'asc')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orderBy('updated_at', 'desc')
                ->paginate(12);
        return RoleResource::collection($data);
    }
    
    public function store(Request $request){
        $user_id = Auth::user()->id;
        $data = new Role();
        $data->name = $request->name;
        $data->level = $request->level;
        $data->user_id = $user_id;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        /*  */
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new RoleResource($data),
        ]);
    }

    public function view($id){
        $data = Role::with(['user'])->find($id);
        return new RoleResource($data);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $data = Role::find($id);
        $data->name = $request->name;
        $data->level = $request->level;
        $data->user_id = $user_id;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new RoleResource($data),
        ]);
    }

    public function delete($id){
        $data = Role::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }

    
}
