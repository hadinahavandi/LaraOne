<?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/management/requests', 'carserviceorder\\Web\\requestController@managelist')->name('requestmanlist');
Route::post('carserviceorder/management/requests/manage', 'carserviceorder\\Web\\requestController@managesave');
Route::get('carserviceorder/management/requests/manage', 'carserviceorder\\Web\\requestController@manageload')->name('requestmanlist');
Route::get('carserviceorder/management/requests/delete', 'carserviceorder\\Web\\requestController@delete');
?>