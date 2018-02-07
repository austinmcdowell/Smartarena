<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LeaderboardController');

Route::get('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('login/google', 'AuthController@redirectToGoogle');
Route::get('login/google/callback', 'AuthController@handleGoogleCallback');

Route::get('/massupload/humans', 'MassHumanUploader@get');
Route::post('/massupload/humans/process', 'MassHumanUploader@process');

Route::get('/massupload/runs', 'MassRunUploader@get');
Route::post('/massupload/runs/process', 'MassRunUploader@process');

Route::get('/profile/{id}', 'ProfileController@get');