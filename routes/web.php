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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/', 'posts\\Web\\postController@index')->name('home');
Route::get('/posts/post{id}', 'posts\\Web\\postController@get');
Route::get('/posts/{page}', 'posts\\Web\\postController@list');
Route::get('/categories', 'tts\\web\\CategoryController@managelist')->name('catmanlist');
Route::post('/categories/manage', 'tts\\web\\CategoryController@managesave');
Route::get('/categories/manage', 'tts\\web\\CategoryController@manageload')->name('catman');
Route::get('/categories/delete', 'tts\\web\\CategoryController@delete');


Route::get('/tts/contexts', 'tts\\web\\ContextController@managelist')->name('contextmanlist');
Route::post('/tts/contexts/manage', 'tts\\web\\ContextController@managesave');
Route::get('/tts/contexts/manage', 'tts\\web\\ContextController@manageload')->name('contextman');
Route::get('/tts/contexts/delete', 'tts\\web\\ContextController@delete');
//Route::get('/{page}', 'posts\\Web\\postController@list');
Route::group(
[
    'prefix' => 'asset_categories',
], function () {

    Route::get('/', 'AssetCategoriesController@index')
         ->name('asset_categories.asset_category.index');

    Route::get('/create','AssetCategoriesController@create')
         ->name('asset_categories.asset_category.create');

    Route::get('/show/{assetCategory}','AssetCategoriesController@show')
         ->name('asset_categories.asset_category.show')
         ->where('id', '[0-9]+');

    Route::get('/{assetCategory}/edit','AssetCategoriesController@edit')
         ->name('asset_categories.asset_category.edit')
         ->where('id', '[0-9]+');

    Route::post('/', 'AssetCategoriesController@store')
         ->name('asset_categories.asset_category.store');
               
    Route::put('asset_category/{assetCategory}', 'AssetCategoriesController@update')
         ->name('asset_categories.asset_category.update')
         ->where('id', '[0-9]+');

    Route::delete('/asset_category/{assetCategory}','AssetCategoriesController@destroy')
         ->name('asset_categories.asset_category.destroy')
         ->where('id', '[0-9]+');

});

Route::post('/financial/payment', 'finance\\web\\RechargeController@verifyPayment');
Route::get('/financial/recharge/{TransactionID}', 'finance\\web\\RechargeController@startPayment');

Route::post('trapp/villa/reserveverify/{OrderID}', 'trapp\\API\\villaController@verifyPaymentAndReserve');
Route::get('trapp/villa/reserveverify/{OrderID}', 'trapp\\API\\villaController@verifyPaymentAndReserve');
Route::get('trapp/villa/testpayment/{OrderID}', 'trapp\\API\\villaController@testPayment');
