<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    // User
    Route::post('user', 'Auth\RegisterController@register');
    Route::get('user', 'UserController@detail');
    Route::post('user/uploadavatar', 'Auth\RegisterController@uploadProfilePicture');

    // Settings
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    // Role and permission
    Route::post('role', 'RoleController@create');
    Route::put('role/{id}', 'RoleController@update');

    Route::post('permissions', 'PermissionController@create');

    // Media manager
    Route::get('media', 'MediaManager\MediaManagerController@index');
    Route::post('media/upload', 'MediaManager\MediaManagerController@uploadMediaImage');
    Route::post('media/delete', 'MediaManager\MediaManagerController@deleteMediaImage');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
