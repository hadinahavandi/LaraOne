<?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/owningtype', 'trapp\\API\\owningtypeController@list');
Route::get('trapp/owningtype/{id}', 'trapp\\API\\owningtypeController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/areatype', 'trapp\\API\\areatypeController@list');
Route::get('trapp/areatype/{id}', 'trapp\\API\\areatypeController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/viewtype', 'trapp\\API\\viewtypeController@list');
Route::get('trapp/viewtype/{id}', 'trapp\\API\\viewtypeController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/structuretype', 'trapp\\API\\structuretypeController@list');
Route::get('trapp/structuretype/{id}', 'trapp\\API\\structuretypeController@get');
?><?php
//------------------------------------------------------------------------------------------------------

Route::get('trapp/villa', 'trapp\\API\\villaController@list');
Route::get('trapp/villa/{id}', 'trapp\\API\\villaController@get');
?>