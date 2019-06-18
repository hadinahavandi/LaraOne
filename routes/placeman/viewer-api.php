<?php
Route::get('/placeman/places', 'placeman\\api\\PlacemanController@listPlaces');
Route::get('/placeman/inactiveplaces', 'placeman\\api\\PlacemanController@listInactivePlaces');
Route::get('/placeman/allplaces', 'placeman\\api\\PlacemanController@listAllPlaces');
Route::get('/placeman/placeactivation/{branch_id}/{isActive}', 'placeman\\api\\PlacemanController@changePlaceActivation');
Route::get('/placeman/provinces', 'placeman\\api\\PlacemanController@listProvinces');
Route::get('/placeman/provinces/{Province_id}', 'placeman\\api\\PlacemanController@listCities');
Route::get('/placeman/provinces/{Province_id}/{cityID}', 'placeman\\api\\PlacemanController@listAreas');
Route::get('/placeman/branches/full/{branch_id}', 'placeman\\api\\PlacemanController@getBranchFullInfo');
Route::get('/placeman/branches/{branch_id}', 'placeman\\api\\PlacemanController@getBranch');
Route::get('/placeman/companies', 'placeman\\api\\PlacemanController@listCompanies');
//------------------------------------------------------------------------------------------------------
Route::get('placeman/place', 'placeman\\API\\PlaceController@list');
Route::get('placeman/place/{id}', 'placeman\\API\\PlaceController@get');
Route::get('placeman/phototype', 'placeman\\API\\phototypeController@list');
Route::get('placeman/phototype/{id}', 'placeman\\API\\phototypeController@get');


?>