<?php
Route::get('/placeman/places', 'placeman\\API\\PlacemanController@listPlaces');
Route::get('/placeman/inactiveplaces', 'placeman\\API\\PlacemanController@listInactivePlaces');
Route::get('/placeman/allplaces', 'placeman\\API\\PlacemanController@listAllPlaces');
Route::get('/placeman/placeactivation/{branch_id}/{isActive}', 'placeman\\API\\PlacemanController@changePlaceActivation');
Route::get('/placeman/provinces', 'placeman\\API\\PlacemanController@listProvinces');
Route::get('/placeman/provinces/{Province_id}', 'placeman\\API\\PlacemanController@listCities');
Route::get('/placeman/provinces/{Province_id}/{cityID}', 'placeman\\API\\PlacemanController@listAreas');
Route::get('/placeman/branches/full/{branch_id}', 'placeman\\API\\PlacemanController@getBranchFullInfo');
Route::get('/placeman/branches/{branch_id}', 'placeman\\API\\PlacemanController@getBranch');
Route::get('/placeman/companies', 'placeman\\API\\PlacemanController@listCompanies');
//------------------------------------------------------------------------------------------------------
Route::get('placeman/place', 'placeman\\API\\PlaceController@list');
Route::get('placeman/place/{id}', 'placeman\\API\\PlaceController@get');

?><?php
//------------------------------------------------------------------------------------------------------
Route::get('placeman/placephoto', 'placeman\\API\\placephotoController@list');
Route::get('placeman/placephoto/{id}', 'placeman\\API\\placephotoController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('placeman/phototype', 'placeman\\API\\phototypeController@list');
Route::get('placeman/phototype/{id}', 'placeman\\API\\phototypeController@get');
?>