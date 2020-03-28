<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('posts/category', 'posts\\API\\categoryController@add');
    Route::put('posts/category/{id}', 'posts\\API\\categoryController@update');
    Route::delete('posts/category/{id}', 'posts\\API\\categoryController@delete');
});
?>
<?php

Route::post('posts/post', 'posts\\API\\postController@add');
Route::put('posts/post/{id}', 'posts\\API\\postController@update');
Route::delete('posts/post/{id}', 'posts\\API\\postController@delete');
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('posts/postcategory', 'posts\\API\\postcategoryController@add');
    Route::put('posts/postcategory/{id}', 'posts\\API\\postcategoryController@update');
    Route::delete('posts/postcategory/{id}', 'posts\\API\\postcategoryController@delete');
});
?>

