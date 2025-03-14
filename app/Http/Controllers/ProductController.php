<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    public function indexByAuthSubsidiary(){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = Product::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return ProductResource::collection($data);
    }
    
    public function indexBySubsidiary($id){
        $data = Product::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return ProductResource::collection($data);
    }
    
    public function index(){
        $data = Product::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return ProductResource::collection($data);
    }
    public function search($search){
        if(!empty($search)){
            $data = Product::with(['user', 'subsidiary'])
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->paginate(12);
            return ProductResource::collection($data);
        }
        $data = Product::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('name', 'ASC')
                ->paginate(12);
        return ProductResource::collection($data);
    }

    public function view($id){
        $data = Product::with(['user', 'subsidiary'])->find($id);
        return new ProductResource($data);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = Product::find($id);
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->description = $request->description;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new ProductResource($data),
        ]);
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = new Product();
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->description = $request->description;
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new ProductResource($data),
        ]);
    }

    public function delete($id){
        $data = Product::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
}
