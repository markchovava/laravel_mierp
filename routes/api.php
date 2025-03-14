<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\SubsidiaryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function() {

    /* PROFILE */
    Route::prefix('profile')->group(function() {
        Route::get('/', [AuthController::class, 'view']);
        Route::post('/', [AuthController::class, 'update']);
    });
    Route::post('/password', [AuthController::class, 'password']);
    Route::post('/email', [AuthController::class, 'email']);
    Route::get('/logout', [AuthController::class, 'logout']);

    /* APPINFO */
    Route::prefix('app-info')->group(function() {
        Route::get('/', [AppInfoController::class, 'view']);
        Route::post('/', [AppInfoController::class, 'store']);
    });

    /* EXPENSE */
    Route::prefix('expense')->group(function() {
        Route::get('/', [ExpenseController::class, 'index']);
        Route::post('/', [ExpenseController::class, 'store']);
        Route::get('/{id}', [ExpenseController::class, 'view']);
        Route::post('/{id}', [ExpenseController::class, 'update']);
        Route::delete('/{id}', [ExpenseController::class, 'delete']);
    });
    Route::get('/expense-search/{search}', [ExpenseController::class, 'search']);
    Route::get('/expense-by-subsidiary/{id}', [ExpenseController::class, 'indexBySubsidiary']);
    
    /* PRODUCT */
    Route::prefix('product')->group(function() {
        Route::get('/', [ProductController::class, 'index']);
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/{id}', [ProductController::class, 'view']);
        Route::post('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'delete']);
    });
    Route::get('/product-search/{search}', [ProductController::class, 'search']);
    Route::get('/product-by-subsidiary/{id}', [ProductController::class, 'indexBySubsidiary']);
    Route::get('/product-by-auth-subsidiary', [ProductController::class, 'indexByAuthSubsidiary']);

    /* PURCHASE */
    Route::prefix('purchase')->group(function() {
        Route::get('/', [PurchaseController::class, 'index']);
        Route::post('/', [PurchaseController::class, 'store']);
        Route::get('/{id}', [PurchaseController::class, 'view']);
        Route::post('/{id}', [PurchaseController::class, 'update']);
        Route::delete('/{id}', [PurchaseController::class, 'delete']);
    });
    Route::get('/purchase-search/{search}', [PurchaseController::class, 'search']);
    Route::get('/purchase-by-subsidiary/{id}', [PurchaseController::class, 'indexBySubsidiary']);
    /* PURCHASEITEM */
    Route::prefix('purchase-item')->group(function() {
        Route::delete('/{id}', [PurchaseItemController::class, 'delete']);
    });
    Route::get('/purchase-items-by-purchase/{id}', [PurchaseItemController::class, 'indexByPurchase']);

    /* SALES */
    Route::prefix('sales')->group(function() {
        Route::get('/', [SalesController::class, 'index']);
        Route::post('/', [SalesController::class, 'store']);
        Route::get('/{id}', [SalesController::class, 'view']);
        Route::post('/{id}', [SalesController::class, 'update']);
        Route::delete('/{id}', [SalesController::class, 'delete']);
    });
    Route::get('/sales-search/{search}', [SalesController::class, 'search']);
    Route::get('/sales-by-subsidiary/{id}', [SalesController::class, 'indexBySubsidiary']);
    /* SALESITEM */
    Route::prefix('sales-item')->group(function() {
        Route::delete('/{id}', [SalesItemController::class, 'delete']);
    });
    Route::get('/sales-items-by-sales/{id}', [SalesItemController::class, 'indexBySales']);

    /* ROLE */
    Route::prefix('role')->group(function() {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{id}', [RoleController::class, 'view']);
        Route::post('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'delete']);
    });
    Route::get('/role-search/{search}', [RoleController::class, 'search']);
    Route::get('/role-all', [RoleController::class, 'indexAll']);

     /* SUBSIDIARY */
     Route::prefix('subsidiary')->group(function() {
        Route::get('/', [SubsidiaryController::class, 'index']);
        Route::post('/', [SubsidiaryController::class, 'store']);
        Route::get('/{id}', [SubsidiaryController::class, 'view']);
        Route::post('/{id}', [SubsidiaryController::class, 'update']);
        Route::delete('/{id}', [SubsidiaryController::class, 'delete']);
    });
    Route::get('/subsidiary-search/{search}', [SubsidiaryController::class, 'search']);
    Route::get('/subsidiary-all', [SubsidiaryController::class, 'indexAll']);


     /* USER */
     Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'view']);
        Route::post('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });
    Route::get('/user-search/{search}', [UserController::class, 'search']);
    Route::get('/user-by-subsidiary/{id}', [UserController::class, 'indexBySubsidiary']);

   

   
   
 
    
});
