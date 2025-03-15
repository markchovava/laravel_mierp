<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    
    public function indexBySubsidiary(){
        $user = Auth::user();
        $data = Expense::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('detail', 'ASC')
                ->paginate(12);
        return ExpenseResource::collection($data);
    }

    public function searchBySubsidiary($search){
        $user = Auth::user();
        if(!empty($search)){
            $data = Expense::with(['user', 'subsidiary'])
                    ->where('subsidiary_id', $user->subsidiary_id)
                    ->where('detail', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('detail', 'ASC')
                    ->paginate(12);
            return ExpenseResource::collection($data);
    }
        $data = Expense::with(['user', 'subsidiary'])
                ->where('subsidiary_id', $user->subsidiary_id)
                ->orderBy('updated_at', 'DESC')
                ->orderBy('detail', 'ASC')
                ->paginate(12);
        return ExpenseResource::collection($data);
    }
    
    public function index(){
        $data = Expense::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('detail', 'ASC')
                ->paginate(12);
        return ExpenseResource::collection($data);
    }

    public function search($search){
        if(!empty($search)){
            $data = Expense::with(['user', 'subsidiary'])
                    ->where('detail', 'LIKE', '%' . $search . '%')
                    ->orderBy('updated_at', 'DESC')
                    ->orderBy('detail', 'ASC')
                    ->paginate(12);
            return ExpenseResource::collection($data);
        }
        $data = Expense::with(['user', 'subsidiary'])
                ->orderBy('updated_at', 'DESC')
                ->orderBy('detail', 'ASC')
                ->paginate(12);
        return ExpenseResource::collection($data);
    }

    public function view($id){
        $data = Expense::with(['user', 'subsidiary'])->find($id);
        return new ExpenseResource($data);
    }

    public function update(Request $request, $id){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = Expense::find($id);
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;;
        $data->detail = $request->detail;
        $data->total = $request->total;
        $data->updated_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new ExpenseResource($data),
        ]);
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $data = new Expense();
        $data->user_id = $user_id;
        $data->subsidiary_id = $user->subsidiary_id;;
        $data->detail = $request->detail;
        $data->total = $request->total;
        $data->created_at = now();
        $data->save();
        return response()->json([
            'status' => 1,
            'message' => 'Data saved successfully.',
            'data' => new ExpenseResource($data),
        ]);
    }

    public function delete($id){
        $data = Expense::find($id);
        $data->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Data deleted successfully.',
        ]);
    }
}
