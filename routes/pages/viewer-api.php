<?php
//------------------------------------------------------------------------------------------------------
Route::get('pages/page', 'pages\\API\\pageController@list');
Route::get('pages/page/byname/{name}', 'pages\\API\\pageController@getByName');
Route::get('pages/page/{id}', 'pages\\API\\pageController@get');
?>