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
Route::get('raise_delete_flag/{record_id}', 'AnalyticsController@raiseDeleteFlag');

// contact us
Route::get('contact_us', 'IndexController@contactUs');
Route::post('contact_us', 'IndexController@postContactUs');

// admin edit
Route::get('modify', 'IndexController@adminModify');
Route::post('modify', 'IndexController@postAdminModify');

Route::get('modify2', 'IndexController@adminConfirm');
Route::post('modify2', 'IndexController@postAdminConfirm');
Route::get('admin_modified_success', 'IndexController@adminModifiedSuccess');

// announcements
Route::get('announcement/edit', 'IndexController@editAnnouncement');
Route::post('announcement/edit', 'IndexController@postEditAnnouncement');

Route::get('updated_success', 'IndexController@updateSuccess');

// leave record
Route::get('leave/list', 'LeaveController@leaveRecord');

// confirm-reset
Route::get('confirm-reset/{uid}', 'AnalyticsController@confirmReset');
Route::get('reset_success', 'AnalyticsController@resetSuccess');

// flyer
Route::get('flyer', 'IndexController@flyer');

// relative links
Route::get('relative_links', 'IndexController@relativeLinks');

// comment zone
Route::get('post_list', 'PostController@index');
Route::get('post_add', 'PostController@showCreatePost');
Route::post('post_add', 'PostController@createPost');
Route::get('post_edit/{aid}', 'PostController@showEditPost');
Route::post('post_edit/{aid}', 'PostController@updatePost');

// post detail
Route::get('post/{pid}', 'PostController@detail');


// DELETE
Route::get('choose_delete', 'DeleteController@showList');
Route::post('choose_delete', 'DeleteController@deleteConfirm');
Route::get('deleted', 'DeleteController@deleted');








// test routes - DO NOT UNCOMMENT 
// Route::get('test', 'AnalyticsController@updateUserGuildwarTimes');

// TestController
Route::get('list', 'TestController@list');
// Route::post('list', 'TestController@postData');




