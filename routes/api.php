<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('admin')->middleware('admin-user')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index']);
        
        Route::resource('companies', CompanyController::class)->except(array(
            'create', 'show', 'edit'
        ));

        Route::resource('categories', CategoryController::class)->except(array(
            'create', 'show', 'destroy'
        ));
        Route::delete('categories/{category:id}', [CategoryController::class, 'destroy']);

        Route::resource('products', ProductController::class)->except(array(
            'create', 'show', 'destroy'
        ));
        Route::delete('products/{product:id}', [ProductController::class, 'destroy']);
        
    });


    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});
