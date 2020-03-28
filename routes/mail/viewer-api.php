<?php
//------------------------------------------------------------------------------------------------------
Route::get('mail/mailpost', 'mail\\API\\mailpostController@list');
Route::get('mail/mailpost/{id}', 'mail\\API\\mailpostController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('mail/mailstatus', 'mail\\API\\mailstatusController@list');
Route::get('mail/mailstatus/{id}', 'mail\\API\\mailstatusController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('mail/mail', 'mail\\API\\mailController@list');
Route::get('mail/mail/{id}', 'mail\\API\\mailController@get');
?>