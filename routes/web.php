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

Route::get('/massupload/humans', 'MassHumanUploader@get')->middleware('auth');
Route::post('/massupload/humans/process', 'MassHumanUploader@process')->middleware('auth');

Route::get('/massupload/runs', 'MassRunUploader@get')->middleware('auth');
Route::post('/massupload/runs/process', 'MassRunUploader@process')->middleware('auth');

Route::get('/userhumanlinker', 'UserHumanLinkController@get')->middleware('auth');
Route::post('/userhumanlinker', 'UserHumanLinkController@post')->middleware('auth');

Route::get('/profile/{id}', 'ProfileController@get');

Route::get('/teamroping/new', 'TeamropingController@new')->middleware('auth');
Route::get('/teamroping/{id}/edit', 'TeamropingController@edit')->middleware('auth');
Route::post('/teamroping/save', 'TeamropingController@save')->middleware('auth');
Route::post('/teamroping/upload', 'TeamropingController@upload')->middleware('auth');
