<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/owningtype', 'trapp\\API\\owningtypeController@add');
    Route::put('trapp/owningtype/{id}', 'trapp\\API\\owningtypeController@update');
    Route::delete('trapp/owningtype/{id}', 'trapp\\API\\owningtypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/areatype', 'trapp\\API\\areatypeController@add');
    Route::put('trapp/areatype/{id}', 'trapp\\API\\areatypeController@update');
    Route::delete('trapp/areatype/{id}', 'trapp\\API\\areatypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/viewtype', 'trapp\\API\\viewtypeController@add');
    Route::put('trapp/viewtype/{id}', 'trapp\\API\\viewtypeController@update');
    Route::delete('trapp/viewtype/{id}', 'trapp\\API\\viewtypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/structuretype', 'trapp\\API\\structuretypeController@add');
    Route::put('trapp/structuretype/{id}', 'trapp\\API\\structuretypeController@update');
    Route::delete('trapp/structuretype/{id}', 'trapp\\API\\structuretypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('trapp/villa/price/{id}', 'trapp\\API\\villaController@GetOrderPrice');
    Route::get('trapp/villa/reservestart/{id}', 'trapp\\API\\villaController@StartReservePayment');
    Route::post('trapp/villa', 'trapp\\API\\villaController@add');
    Route::get('trapp/userfullinfo', 'trapp\\API\\villaController@getUserFullInfo');
    Route::put('trapp/villa/{id}', 'trapp\\API\\villaController@update');
    Route::delete('trapp/villa/{id}', 'trapp\\API\\villaController@delete');


//------------------------------------------------------------------------------------------------------
    Route::get('trapp/inactivevilla', 'trapp\\API\\villaController@inactiveList');
    Route::get('trapp/villa', 'trapp\\API\\villaController@list');
    Route::get('trapp/villa/{id}', 'trapp\\API\\villaController@get');
    Route::get('trapp/villa/{id}/reserveddays', 'trapp\\API\\villaController@getReservedDaysOfVilla');
});
?>
<?php

?>
<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/order', 'trapp\\API\\orderController@add');
    Route::put('trapp/order/{id}', 'trapp\\API\\orderController@update');
    Route::delete('trapp/order/{id}', 'trapp\\API\\orderController@delete');
//------------------------------------------------------------------------------------------------------
    Route::get('trapp/order', 'trapp\\API\\orderController@list');
    Route::get('trapp/order/user', 'trapp\\API\\orderController@UserOrdersList');
    Route::get('trapp/order/villa', 'trapp\\API\\orderController@villaorderslist');
    Route::get('trapp/order/{id}', 'trapp\\API\\orderController@get');
});
?>


<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/villaowner', 'trapp\\API\\villaownerController@add');
    Route::put('trapp/villaowner/{id}', 'trapp\\API\\villaownerController@update');
    Route::delete('trapp/villaowner/{id}', 'trapp\\API\\villaownerController@delete');

    Route::get('trapp/villaowner/byuser/{id}', 'trapp\\API\\villaownerController@getFromUser');
//------------------------------------------------------------------------------------------------------
    Route::get('trapp/villaowner', 'trapp\\API\\villaownerController@list');
    Route::get('trapp/villaowner/{id}', 'trapp\\API\\villaownerController@get');
});
?>
