<?php
//------------------------------------------------------------------------------------------------------
Route::get('research/management/researchers', 'research\\Web\\researcherController@managelist')->name('researchermanlist');
Route::post('research/management/researchers/manage', 'research\\Web\\researcherController@managesave');
Route::get('research/management/researchers/manage', 'research\\Web\\researcherController@manageload')->name('researchermanlist');
Route::get('research/management/researchers/delete', 'research\\Web\\researcherController@delete');
?>