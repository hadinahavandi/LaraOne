<?php
//------------------------------------------------------------------------------------------------------
Route::get('mail/management/mails', 'mail\\Web\\mailController@managelist')->name('mailmanlist');
Route::post('mail/management/mails/manage', 'mail\\Web\\mailController@managesave');
Route::get('mail/management/mails/manage', 'mail\\Web\\mailController@manageload')->name('mailmanlist');
Route::get('mail/management/mails/delete', 'mail\\Web\\mailController@delete');
?>