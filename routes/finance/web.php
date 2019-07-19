<?php
//------------------------------------------------------------------------------------------------------
Route::get('finance/management/transactions', 'finance\\Web\\transactionController@managelist')->name('transactionmanlist');
Route::post('finance/management/transactions/manage', 'finance\\Web\\transactionController@managesave');
Route::get('finance/management/transactions/manage', 'finance\\Web\\transactionController@manageload')->name('transactionmanlist');
Route::get('finance/management/transactions/delete', 'finance\\Web\\transactionController@delete');
?>