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

Route::get('/', function () {
    return view('welcome');
});

// login routes
Route::get('login', 'LoginController@memberLogin');
Route::post('login', 'LoginController@postLogin');

// logout
Route::get('logout', 'LoginController@logout');

// forget password
Route::get('forgot', 'LoginController@forgot');
Route::post('forgot', 'LoginController@postForgot');
Route::get('reset_password', 'LoginController@resetPassword');
Route::post('reset_password', 'LoginController@postResetPassword');
Route::get('reset_password_success', 'LoginController@resetPasswordSuccess');

// register routes
Route::get('register', 'RegisterController@register');
Route::post('register', 'RegisterController@postRegister');
Route::get('register_success', 'RegisterController@registerSuccess');

// index routes
Route::get('index', 'IndexController@index');

Route::get('capability', 'IndexController@capability');
Route::get('announce', 'IndexController@announce');
Route::get('guildwar', 'IndexController@guildwar');
Route::get('commemt', 'IndexController@commemt');

// account settings
Route::get('account/{uid}', 'IndexController@account');
Route::post('account/{uid}', 'IndexController@postAccount');
Route::get('modified_success', 'IndexController@modifiedSuccess');

// analysis
Route::get('analysis', 'AnalyticsController@analysisAll');

// save guildwar data
Route::get('guildwar_update', 'AnalyticsController@guildwarData');
Route::post('guildwar_update', 'AnalyticsController@postGuildwarData');
Route::get('insert_success', 'AnalyticsController@insertSuccess');

Route::get('guildwar_data_list', 'AnalyticsController@guildwarDataList');

// contact us
Route::get('contact_us', 'IndexController@contactUs');
Route::post('contact_us', 'IndexController@postContactUs');


// test routes - DO NOT UNCOMMENT 
// Route::get('test', 'AnalyticsController@updateUserGuildwarTimes');

// TestController
// Route::get('list', 'TestController@list');
// Route::post('list', 'TestController@postData');




