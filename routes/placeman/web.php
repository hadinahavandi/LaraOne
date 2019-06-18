<?php
//------------------------------------------------------------------------------------------------------
Route::get('placeman/management/places', 'placeman\\Web\\placeController@managelist')->name('placemanlist');
Route::post('placeman/management/places/manage', 'placeman\\Web\\placeController@managesave');
Route::get('placeman/management/places/manage', 'placeman\\Web\\placeController@manageload')->name('placemanlist');
Route::get('placeman/management/places/delete', 'placeman\\Web\\placeController@delete');
?>