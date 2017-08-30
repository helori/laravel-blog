<?php


$controller = '\Helori\LaravelBlog\Controllers\BlogArticlesController';

Route::post('/api/blog-article', ['uses' => $controller.'@create']);
Route::get('/api/blog-article/{id?}', ['uses' => $controller.'@read']);
Route::put('/api/blog-article/{id}', ['uses' => $controller.'@update']);
Route::delete('/api/blog-article/{id}', ['uses' => $controller.'@delete']);

$controller = '\Helori\LaravelBlog\Controllers\BlogCategoriesController';

Route::post('/api/blog-category', ['uses' => $controller.'@create']);
Route::get('/api/blog-category/{id?}', ['uses' => $controller.'@read']);
Route::put('/api/blog-category/{id}', ['uses' => $controller.'@update']);
Route::delete('/api/blog-category/{id}', ['uses' => $controller.'@delete']);
