<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Subsidiary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function indexBySubsidiaryDashboard(){
        $auth = Auth::user();
        $users = User::where('subsidiary_id', $auth->subsidiary_id)->count();
        $products = Product::where('subsidiary_id', $auth->subsidiary_id)->count();
        // SALES
        $latestSales = Sales::max('created_at');
        $latestDate = Carbon::parse($latestSales)->toDateString();
        $salesTotal = Sales::whereDate('created_at', $latestDate)
                    ->where('subsidiary_id', $auth->subsidiary_id)
                    ->sum('total');
        //  PURCHASE
        $latestPurchase = Purchase::max('created_at');
        $latestDate = Carbon::parse($latestPurchase)->toDateString();
        $purchaseTotal = Purchase::whereDate('created_at', $latestDate)
                    ->where('subsidiary_id', $auth->subsidiary_id)
                    ->sum('total');
        // EXPENSE
        $latestExpense = Expense::max('created_at');
        $latestDate = Carbon::parse($latestExpense)->toDateString();
        $expenseTotal = Expense::whereDate('created_at', $latestDate)
                    ->where('subsidiary_id', $auth->subsidiary_id)
                    ->sum('total');
        return response()->json([
            'users_total' => $users,
            'products_total' => $products,
            'sales_total' => $salesTotal,
            'purchase_total' => $purchaseTotal,
            'expense_total' => $expenseTotal,
        ]);
    }

    public function indexDashboard(){
        $users = User::count();
        $products = Product::count();
        $subsidiary = Subsidiary::count();
        // SALES
        $latestSales = Sales::max('created_at');
        $latestDate = Carbon::parse($latestSales)->toDateString();
        $salesTotal = Sales::whereDate('created_at', $latestDate)
                    ->sum('total');
        //  PURCHASE
        $latestPurchase = Purchase::max('created_at');
        $latestDate = Carbon::parse($latestPurchase)->toDateString();
        $purchaseTotal = Purchase::whereDate('created_at', $latestDate)
                    ->sum('total');
        // EXPENSE
        $latestExpense = Expense::max('created_at');
        $latestDate = Carbon::parse($latestExpense)->toDateString();
        $expenseTotal = Expense::whereDate('created_at', $latestDate)
                    ->sum('total');
        return response()->json([
            'users_total' => $users,
            'products_total' => $products,
            'sales_total' => $salesTotal,
            'purchase_total' => $purchaseTotal,
            'expense_total' => $expenseTotal,
            'subsidiary_total' => $subsidiary,
        ]);
    }
}
