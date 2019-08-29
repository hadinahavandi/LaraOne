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
Route::get('trapp/villaownerbalances', 'trapp\\API\\villaownerController@getVillaOwnerBalances');
?>
<?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/option', 'trapp\\API\\optionController@list');
Route::get('trapp/option/{id}', 'trapp\\API\\optionController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('trapp/villaoption', 'trapp\\API\\villaoptionController@list');
Route::get('trapp/villaoption/byvilla/{VillaID}', 'trapp\\API\\villaoptionController@listVillaOptions');
Route::get('trapp/villaoption/{id}', 'trapp\\API\\villaoptionController@get');
?>