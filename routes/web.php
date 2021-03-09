<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('install', function () {
    \Illuminate\Support\Facades\Artisan::call('app:install');
    dd("app:install");
});
Route::get('update', function () {
    \Illuminate\Support\Facades\Artisan::call('app:update');
    dd("app:update");
});
Route::get('cache_clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    dd("cache:clear");
});
Route::get('config_clear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    dd("config:clear");
});
Route::get('storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd("storage");
});
Route::get('migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    dd("migrate");
});
Route::get('seed', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed');
    dd("seed");
});
Route::get('up', function () {
    \Illuminate\Support\Facades\Artisan::call('up');
    dd("live");
});
Route::get('down', function () {
    \Illuminate\Support\Facades\Artisan::call('down');
    dd("maintenance");
});

Route::get('/', function () {
    return redirect(route('products.index'));
});
Route::get('/example_test', function () {
    return view('welcome');
});
Auth::routes([
    'register' => false
]);

Route::get('/home', function () {
    return redirect(route('products.index'));
})->name('home');
Route::get('storage/{path}', 'StorageController')->name('storage')->where('path', '[\-\/\w\.]+');
Route::resource('roles', 'RoleController');
Route::resource('transaction_statuses', 'TransactionStatusController');
Route::resource('product_categories', 'ProductCategoryController');
Route::get('products/adjust/{product}', 'ProductController@adjust')->name('products.adjust');
Route::resource('products', 'ProductController');
Route::resource('users', 'UserController');
Route::resource('transaction_ins', 'TransactionInController');
Route::resource('transaction_outs', 'TransactionOutController');
Route::get('stock_report', 'StockReportController')->name('stock_report');
Route::get('transaction_report', 'TransactionReportController')->name('transaction_report');
Route::post('institutions/cookie', 'InstitutionController@cookie')->name('institutions.cookie');
Route::resource('institutions', 'InstitutionController');
Route::get('notification', 'NotificationController')->name('notification');
