<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function generateRandomText($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $shuffled = str_shuffle($characters);
        return substr($shuffled, 0, $length);
    }

    public function indexBySubsidiary($id){
        $data = User::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return UserResource::collection($data);
    }
    
    public function index(){
        $user_id = Auth::user()->id;
        $data = User::with(['role', 'subsidiary'])
                ->where('id', '!=', $user_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return UserResource::collection($data);
    }

    public function search($search){
        $user_id = Auth::user()->id;
        if(!empty($search)) {
            $data = User::with(['role', 'subsidiary'])
                    ->where('id', '!=', $user_id)
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->paginate(12);
            return UserResource::collection($data);
        }
        $data = User::with(['role', 'subsidiary'])
                ->where('id', '!=', $user_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return UserResource::collection($data);
    }

    public function view($id){
        $data = User::with(['role', 'subsidiary'])->find($id);
        return new UserResource($data);
    }

    public function store(Request $request) {
        $user = User::where('email', $request->email)->first();
        if(isset($user)) {
            return response()->json([
                'status' => 0,
                'message' => 'Email already exist, try another one.'
            ]);
        }
        $code = $this->generateRandomText();
        $data = new User();
        $data->role_level = $request->role_level ?? 4;
        $data->subsidiary_id = $request->subsidiary_id;
        $data->is_admin = $request->is_admin;
        $data->name = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->position = $request->position;
        $data->password = Hash::make($code);
        $data->code = $code;
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        /*  */
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new UserResource($data),
        ]);

    }

    public function update(Request $request, $id){
        $email = User::where('id', '!=', $id)
            ->where('email', $request->email)
            ->first();
        if(isset($email)){
            return response()->json([
                'status' => 0,
                'message' => 'Email already exists, try another one.',
            ]);
        }
        $code = $this->generateRandomText();
        $data = User::find($id);
        $data->role_level = $request->role_level ?? 4;
        $data->subsidiary_id = $request->subsidiary_id;
        $data->is_admin = $request->is_admin;
        $data->name = $request->name;
        $data->address = $request->address;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->position = $request->position;
        $data->updated_at = now();
        $data->save();
        /*  */
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new UserResource($data),
        ]);
    }

    public function delete($id){
        $data = User::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }


}
