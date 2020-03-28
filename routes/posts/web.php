<?php
//------------------------------------------------------------------------------------------------------
Route::get('posts/management/categorys', 'posts\\Web\\categoryController@managelist')->name('categorymanlist');
Route::post('posts/management/categorys/manage', 'posts\\Web\\categoryController@managesave');
Route::get('posts/management/categorys/manage', 'posts\\Web\\categoryController@manageload')->name('categorymanlist');
Route::get('posts/management/categorys/delete', 'posts\\Web\\categoryController@delete');
?>