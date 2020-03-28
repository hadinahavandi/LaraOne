<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('research/workstatus', 'research\\API\\workstatusController@add');
    Route::put('research/workstatus/{id}', 'research\\API\\workstatusController@update');
    Route::delete('research/workstatus/{id}', 'research\\API\\workstatusController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('research/researcher/makemaillist', 'research\\API\\researcherController@makeMailList');
    Route::get('research/researcher/{id}', 'research\\API\\researcherController@get');
    Route::put('research/researcher/{id}', 'research\\API\\researcherController@update');
    Route::delete('research/researcher/{id}', 'research\\API\\researcherController@delete');
    Route::get('research/researcher', 'research\\API\\researcherController@list');
});
?>