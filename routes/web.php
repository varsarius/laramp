<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'ImageController@show');

Route::get('/login', 'AuthController@loginPage');
Route::get('/logout', 'AuthController@logout');
Route::post('/login', 'AuthController@login');

Route::post('/photo', 'ImageController@create');
Route::delete('/delete', 'ImageController@delete');
Route::post('/perm', 'ImageController@permit');
Route::post('/edit/{id}', 'ImageController@edit');
Route::post('/editsave/{id}', 'ImageController@editsave');
