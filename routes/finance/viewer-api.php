<?php
//------------------------------------------------------------------------------------------------------
Route::get('finance/transaction', 'finance\\API\\transactionController@list');
Route::get('finance/transaction/{id}', 'finance\\API\\transactionController@get');
?>