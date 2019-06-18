<?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/management/villas', 'trapp\\Web\\villaController@managelist')->name('villamanlist');
Route::post('trapp/management/villas/manage', 'trapp\\Web\\villaController@managesave');
Route::get('trapp/management/villas/manage', 'trapp\\Web\\villaController@manageload')->name('villamanlist');
Route::get('trapp/management/villas/delete', 'trapp\\Web\\villaController@delete');
?>