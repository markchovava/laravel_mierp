<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseItemResource;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    
    public function indexByPurchase($id) {
        $data = PurchaseItem::with('product')->where('purchase_id', $id)->get();
        return PurchaseItemResource::collection($data);
    }

    public function delete($id) {
        $data = PurchaseItem::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
}
