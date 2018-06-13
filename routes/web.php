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

Auth::routes();

Route::get('/', 'SPAController');
Route::get('/leaderboard', 'LeaderboardController');

// Route::get('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('login/google', 'AuthController@redirectToGoogle');
Route::get('login/google/callback', 'AuthController@handleGoogleCallback');
Route::get('login/facebook', 'AuthController@redirectToFacebook');
Route::get('login/facebook/callback', 'AuthController@handleFacebookCallback');

Route::get('/massupload/humans', 'MassHumanUploader@get')->middleware('auth', 'admin');
Route::post('/massupload/humans/process', 'MassHumanUploader@process')->middleware('auth', 'admin');

Route::get('/massupload/runs', 'MassRunUploader@get')->middleware('auth', 'admin');
Route::post('/massupload/runs/process', 'MassRunUploader@process')->middleware('auth', 'admin');
Route::post('/massupload/runs/uploadVideo', 'MassRunUploader@uploadVideo')->middleware('auth', 'admin');

Route::get('/createhuman', 'CreateHumanController@get')->middleware('auth', 'admin');
Route::post('/createhuman', 'CreateHumanController@post')->middleware('auth', 'admin');

Route::get('/userhumanlinker', 'UserHumanLinkController@get')->middleware('auth', 'admin');
Route::post('/userhumanlinker', 'UserHumanLinkController@post')->middleware('auth', 'admin');

Route::get('/profile/{id}', 'ProfileController@get');

Route::get('/teamroping/new/{videoId}', 'TeamropingController@new')->middleware('auth');
Route::get('/teamroping/{id}/edit', 'TeamropingController@edit')->middleware('auth');
Route::post('/teamroping/save', 'TeamropingController@save')->middleware('auth');

Route::get('/videos/new', 'VideoController@new')->middleware('auth');
Route::post('/videos/upload', 'VideoController@upload')->middleware('auth');