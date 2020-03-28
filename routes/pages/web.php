<?php
//------------------------------------------------------------------------------------------------------
Route::get('pages/management/pages', 'pages\\Web\\pageController@managelist')->name('pagemanlist');
Route::post('pages/management/pages/manage', 'pages\\Web\\pageController@managesave');
Route::get('pages/management/pages/manage', 'pages\\Web\\pageController@manageload')->name('pagemanlist');
Route::get('pages/management/pages/delete', 'pages\\Web\\pageController@delete');
?>