<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('product_categories', 'Api\ProductCategoryController', [ 'as' => 'api' ]);
Route::post('products/adjust/{product}', 'Api\ProductController@adjust', [ 'as' => 'api' ])->name('products.adjust');
Route::apiResource('products', 'Api\ProductController', [ 'as' => 'api' ]);
Route::apiResource('transaction_statuses', 'Api\TransactionStatusController', [ 'as' => 'api' ]);
Route::apiResource('users', 'Api\UserController', [ 'as' => 'api' ]);
Route::apiResource('institutions', 'Api\InstitutionController', [ 'as' => 'api' ]);
Route::apiResource('roles', 'Api\RoleController', [ 'as' => 'api' ]);
Route::apiResource('transaction_ins', 'Api\TransactionInController', [ 'as' => 'api' ]);
Route::apiResource('transaction_outs', 'Api\TransactionOutController', [ 'as' => 'api' ]);
