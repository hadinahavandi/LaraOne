<?php
//------------------------------------------------------------------------------------------------------
Route::get('publicrelations/management/messages', 'publicrelations\\Web\\messageController@managelist')->name('messagemanlist');
Route::post('publicrelations/management/messages/manage', 'publicrelations\\Web\\messageController@managesave');
Route::get('publicrelations/management/messages/manage', 'publicrelations\\Web\\messageController@manageload')->name('messagemanlist');
Route::get('publicrelations/management/messages/delete', 'publicrelations\\Web\\messageController@delete');
?>