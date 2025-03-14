<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesItemResource;
use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{

    public function indexBySales($id) {
        $data = SalesItem::with('product')->where('sales_id', $id)->get();
        return SalesItemResource::collection($data);
    }
    
    public function delete($id) {
        $data = SalesItem::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
}
