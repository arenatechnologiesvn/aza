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

    Route::get('/user', 'UserController@detail');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
//    Route::post('user', 'UserController@create')->middleware('can:create,App\User');
    Route::post('user', 'Auth\RegisterController@register');
    Route::post('role', 'RoleController@create');
    Route::put('role/{id}', 'RoleController@update');

    Route::post('permissions', 'PermissionController@create');
});
//Route::get('/api/login', function () {
//    return \Illuminate\Support\Facades\Auth::user();
//})->name('login');

//Route::post('register', 'Auth\RegisterController@register')->middleware('can:create-user');


Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
