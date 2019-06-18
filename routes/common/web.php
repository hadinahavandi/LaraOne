<?php
//------------------------------------------------------------------------------------------------------
Route::get('common/management/dates', 'common\\Web\\dateController@managelist')->name('datemanlist');
Route::post('common/management/dates/manage', 'common\\Web\\dateController@managesave');
Route::get('common/management/dates/manage', 'common\\Web\\dateController@manageload')->name('datemanlist');
Route::get('common/management/dates/delete', 'common\\Web\\dateController@delete');
?>