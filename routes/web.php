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

//首页
Route::get('/', 'PagesController@root')->name('root');

//用户
Route::resource('users', 'UsersController', [
    'only' => ['show', 'store', 'edit', 'update']
]);

//帖子
Route::resource('categories', 'CategoriesController', [
    'only' => ['show']
]);
Route::resource('posts', 'PostsController');

//测试
Route::get('/test', function() {

});


//只允许游客
Route::group([
    'middleware' => 'guest'
], function() {
    //用户注册
    Route::get('register', 'UsersController@create')->name('register');
    Route::post('users/get_validate_email', 'UsersController@getValidateEmail')->name('users.getValidateEmail');
    Route::get('users/validate_email/{token}/{email}', 'UsersController@validateEmail')->name('users.validateEmail');

    //登录
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login');

    //忘记密码
    Route::get('password/forget', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.forget');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
});


//只允许登陆用户
Route::group([
    'middleware' => 'auth'
], function() {
    //登出
    Route::delete('logout', 'Auth\LoginController@logout')->name('logout');

});