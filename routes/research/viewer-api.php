<?php
//------------------------------------------------------------------------------------------------------
Route::get('research/workstatus', 'research\\API\\workstatusController@list');
Route::get('research/workstatus/{id}', 'research\\API\\workstatusController@get');
?><?php
//------------------------------------------------------------------------------------------------------

Route::post('research/researcher', 'research\\API\\researcherController@add');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('research/universitygrade', 'research\\API\\universitygradeController@list');
Route::get('research/universitygrade/{id}', 'research\\API\\universitygradeController@get');
?>