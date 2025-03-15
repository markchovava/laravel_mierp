<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesResource;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function indexBySubsidiary(){
        $user = Auth::user();
        $data = Sales::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('total', 'DESC')
                ->paginate(12);
        return SalesResource::collection($data);
    }

    public function searchBySubsidiary($search){
        $user = Auth::user();
        if(!empty($search)){
            $data = Sales::with(['user', 'subsidiary'])
                    ->where('subsidiary_id', $user->subsidiary_id)
                    ->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('total', 'DESC')
                    ->paginate(12);
            return SalesResource::collection($data);
        }
        $data = Sales::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return SalesResource::collection($data);
    }
    
    public function index(){
        $data = Sales::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('total', 'DESC')
                ->paginate(12);
        return SalesResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = Sales::with(['user', 'subsidiary'])
                    ->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('total', 'DESC')
                    ->paginate(12);
            return SalesResource::collection($data);
        }
        $data = Sales::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return SalesResource::collection($data);
    }

    public function view($id){
        $data = Sales::with(['user', 'subsidiary', 'sales_items'])->find($id);
        return new SalesResource($data);
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = new Sales();
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;
        $data->total = $request->total;
        $data->quantity = $request->quantity;
        $data->updated_at = now();
        $data->save();
        $items = $request->sales_items;
        for( $i = 0; $i < count($items); $i++) {
            $a = new SalesItem();
            $a->user_id = $user_id;
            $a->subsidiary_id = $user->subsidiary_id;
            $a->sales_id = $data->id;
            $a->product_id = $items[$i]['id'];
            $a->price = $items[$i]['price'];
            $a->quantity = $items[$i]['item_quantity'];
            $a->total = $items[$i]['total'];
            $a->created_at = now();
            $a->updated_at = now();
            $a->save();
        }
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new SalesResource($data),
        ]);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = Sales::find($id);
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;
        $data->total = $request->total;
        $data->quantity = $request->quantity;
        $data->updated_at = now();
        $data->save();
        SalesItem::where('sales_id', $id)->delete();
        $items = json_decode($request->sales_items, true);
        for( $i = 0; $i < count($items); $i++) {
            $a = new SalesItem();
            $a->user_id = $user_id;
            $a->subsidiary_id = $user->subsidiary_id;
            $a->sales_id = $data->id;
            $a->product_id = $items[$i]['id'];
            $a->price = $items[$i]['price'];
            $a->quantity = $items[$i]['item_quantity'];
            $a->total = $items[$i]['total'];
            $a->created_at = now();
            $a->updated_at = now();
            $a->save();
        }
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new SalesResource($data),
        ]);
    }

    public function delete($id){
        $data = Sales::find($id);
        SalesItem::where('sales_id', $id)->delete();
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
}
