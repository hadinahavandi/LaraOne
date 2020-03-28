<?php
//------------------------------------------------------------------------------------------------------
Route::get('posts/category', 'posts\\API\\categoryController@list');
Route::get('posts/category/{id}', 'posts\\API\\categoryController@get');
?>
<?php

Route::get('posts/post', 'posts\\API\\postController@list');
Route::get('posts/post/{id}', 'posts\\API\\postController@get');
Route::get('posts/catposts/{catname}', 'posts\\API\\postController@listCategoryPosts');

//------------------------------------------------------------------------------------------------------
Route::get('posts/postcategory', 'posts\\API\\postcategoryController@list');
Route::get('posts/postcategory/{id}', 'posts\\API\\postcategoryController@get');
?>
