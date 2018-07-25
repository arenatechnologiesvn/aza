<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth.jwt:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    // User
    Route::post('user', 'Auth\RegisterController@register');
    Route::get('user', 'UserController@detail');
    Route::post('user/uploadavatar', 'Auth\RegisterController@uploadProfilePicture');

    // Settings
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    // Role and permission
    Route::resource('role', 'RoleController');
    Route::delete('roles/deletes', 'RoleController@deletes');
    Route::resource('roles', 'RoleController');
    Route::resource('employees', 'EmployeeController');
    Route::resource('favorites', 'FavoriteController');
    Route::resource('carts', 'CartController');
    Route::resource('customers', 'CustomerController');
    Route::resource('shops', 'ShopController');
    Route::resource('orders', 'OrderController');

    Route::get('permissions/roles','PermissionController@getByRole');
    Route::resource('permissions', 'PermissionController');

    // Media manager
    Route::get('media', 'MediaManager\MediaManagerController@index');
    Route::post('media/upload', 'MediaManager\MediaManagerController@uploadMediaImage');
    Route::post('media/delete', 'MediaManager\MediaManagerController@deleteMediaImage');

    // Product category
    Route::resource('categories', 'Product\CategoryController');

    // Product provider
    Route::resource('providers', 'Product\ProviderController');

    // Products
    Route::resource('products', 'Product\ProductController');
    Route::get('products/category/{id}','Product\ProductController@getByCategory');

    // Report
    Route::get('report/customer/revenue','ReportController@getCustomerRevenue');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
