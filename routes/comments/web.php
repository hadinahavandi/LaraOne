<?php
//------------------------------------------------------------------------------------------------------
Route::get('comments/management/tempusers', 'comments\\Web\\tempuserController@managelist')->name('tempusermanlist');
Route::post('comments/management/tempusers/manage', 'comments\\Web\\tempuserController@managesave');
Route::get('comments/management/tempusers/manage', 'comments\\Web\\tempuserController@manageload')->name('tempusermanlist');
Route::get('comments/management/tempusers/delete', 'comments\\Web\\tempuserController@delete');
?>