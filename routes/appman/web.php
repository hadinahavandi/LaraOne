<?php
//------------------------------------------------------------------------------------------------------
Route::get('appman/management/apperrors', 'appman\\Web\\apperrorController@managelist')->name('apperrormanlist');
Route::post('appman/management/apperrors/manage', 'appman\\Web\\apperrorController@managesave');
Route::get('appman/management/apperrors/manage', 'appman\\Web\\apperrorController@manageload')->name('apperrormanlist');
Route::get('appman/management/apperrors/delete', 'appman\\Web\\apperrorController@delete');
?>