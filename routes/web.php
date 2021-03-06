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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/logout', 'AuthController@logout');

Route::get('/confirmation', function() {
  return view('subscriptions.confirmation');
});

// Social Auth
Route::get('login/google', 'AuthController@redirectToGoogle');
Route::get('login/google/callback', 'AuthController@handleGoogleCallback');
Route::get('login/facebook', 'AuthController@redirectToFacebook');
Route::get('login/facebook/callback', 'AuthController@handleFacebookCallback');

// Chose a plan
Route::get('/choose-plan', 'SubscriptionController@get');
Route::post('/charge', 'SubscriptionController@charge');

Route::get('/', 'SPAController');
Route::get('/search', 'SearchController');
Route::get('/home', 'HomeController');
Route::get('/leaderboard/videos', 'LeaderboardController@videos');

Route::get('/humans', 'HumanController@get');
Route::post('/humans/save', 'HumanController@save');

Route::get('/events', 'EventController@get');

Route::get('/massupload/humans', 'MassHumanUploader@get')->middleware('auth', 'admin');
Route::post('/massupload/humans/process', 'MassHumanUploader@process')->middleware('auth', 'admin');

Route::get('/massupload/runs/events', 'MassRunUploader@events')->middleware('auth', 'admin');
Route::post('/massupload/runs/process', 'MassRunUploader@process')->middleware('auth', 'admin');
Route::post('/massupload/runs/uploadVideo', 'MassRunUploader@uploadVideo')->middleware('auth', 'admin');

Route::post('/createhuman', 'CreateHumanController@post')->middleware('auth', 'admin');

Route::get('/user-human-linker-data', 'UserHumanLinkController@get')->middleware('auth', 'admin');
Route::post('/link-user-human', 'UserHumanLinkController@post')->middleware('auth', 'admin');

Route::get('/profile/{id}', 'ProfileController@get');
Route::get('/hire/{id}', 'ProfileController@hire')->middleware('auth', 'subscribed');

Route::get('/teamroping/new/{videoId}', 'RunController@new')->middleware('auth', 'subscribed');
Route::get('/teamroping/{id}/edit', 'RunController@edit')->middleware('auth', 'subscribed');
Route::get('/run/{id}', 'RunController@get')->middleware('auth', 'subscribed');
Route::post('/run/save', 'RunController@save')->middleware('auth', 'subscribed');

Route::get('/video/{id}', 'VideoController@get');
Route::get('/video/data/{id}', 'VideoController@data');
Route::post('/videos/upload', 'VideoController@upload')->middleware('auth', 'subscribed');
