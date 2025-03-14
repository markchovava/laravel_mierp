<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubsidiaryResource;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubsidiaryController extends Controller
{
   
    public function indexAll(){
        $data = Subsidiary::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->get();
        return SubsidiaryResource::collection($data);
    }
    public function index(){
        $data = Subsidiary::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return SubsidiaryResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = Subsidiary::with(['user'])
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->paginate(12);
            return SubsidiaryResource::collection($data);
        }
        $data = Subsidiary::with(['user'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return SubsidiaryResource::collection($data);
    }

    public function view($id){
        $data = Subsidiary::with(['user'])->find($id);
        return new SubsidiaryResource($data);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $data = Subsidiary::find($id);
        $data->user_id = $user_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->description = $request->description;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new SubsidiaryResource($data),
        ]);
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;
        $data = new Subsidiary();
        $data->user_id = $user_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->description = $request->description;
        $data->created_at = now();
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new SubsidiaryResource($data),
        ]);
    }

    public function delete($id){
        $data = Subsidiary::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
    
}
