<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    
    public function indexBySubsidiary(){
        $user = Auth::user();
        $data = Purchase::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return PurchaseResource::collection($data);
    }

    public function searchBySubsidiary($search){
        $user = Auth::user();
        if(!empty($search)){
            $data = Purchase::with(['user', 'subsidiary'])
                    ->where('subsidiary_id', $user->subsidiary_id)
                    ->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('supplier_name', 'ASC')
                    ->paginate(12);
            return PurchaseResource::collection($data);
        }
        $data = Purchase::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return PurchaseResource::collection($data);
    }
    
    public function index(){
        $data = Purchase::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return PurchaseResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = Purchase::with(['user', 'subsidiary'])
                    ->where('supplier_name', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('supplier_name', 'ASC')
                    ->paginate(12);
            return PurchaseResource::collection($data);
        }
        $data = Purchase::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('supplier_name', 'ASC')
                ->paginate(12);
        return PurchaseResource::collection($data);
    }

    public function view($id){
        $data = Purchase::with(['user', 'subsidiary', 'purchase_items'])->find($id);
        return new PurchaseResource($data);
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = new Purchase();
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;
        $data->total = $request->total;
        $data->quantity = $request->quantity;
        $data->supplier_name = $request->supplier_name;
        $data->supplier_phone = $request->supplier_phone;
        $data->supplier_email = $request->supplier_email;
        $data->supplier_address = $request->supplier_address;
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        $items = $request->purchase_items;
        for( $i = 0; $i < count($items); $i++) {
            $a = new PurchaseItem();
            $a->user_id = $user_id;
            $a->subsidiary_id = $user->subsidiary_id;
            $a->purchase_id = $data->id;
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
            'data' => new PurchaseResource($data),
        ]);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = Purchase::find($id);
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;
        $data->total = $request->total;
        $data->quantity = $request->quantity;
        $data->supplier_name = $request->supplier_name;
        $data->supplier_phone = $request->supplier_phone;
        $data->supplier_email = $request->supplier_email;
        $data->supplier_address = $request->supplier_address;
        $data->updated_at = now();
        $data->created_at = now();
        $data->save();
        PurchaseItem::where('purchase_id', $id)->delete();
        $items = $request->purchase_items;
        for( $i = 0; $i < count($items); $i++) {
            $a = new PurchaseItem();
            $a->user_id = $user_id;
            $a->subsidiary_id = $user->subsidiary_id;
            $a->purchase_id = $data->id;
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
            'data' => new PurchaseResource($data),
        ]);
    }

    public function delete($id){
        $data = Purchase::find($id);
        PurchaseItem::where('purchase_id', $id)->delete();
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }

}
