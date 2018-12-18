<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Category;

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

//粉丝和已关注用户
Route::get('users/{user}/followers', 'FollowsController@followers')->name('users.followers');
Route::get('users/{user}/followees', 'FollowsController@followees')->name('users.followees');

//帖子和回复
Route::resource('categories', 'CategoriesController', [
    'only' => ['show']
]);
Route::resource('posts', 'PostsController', [
    'except' => ['show']
]);
Route::get('posts/{post}/{slug?}', 'PostsController@show')->name('posts.show');
Route::post('posts/image', 'PostsController@imageStore')->name('posts.image_store');    //发帖时上传图片
Route::patch('posts/{post}/good', 'PostsController@switchGood')->name('posts.switch_good'); //加精/取消
Route::resource('replies', 'RepliesController', [
    'only' => ['show', 'store', 'destroy']
]);


//测试
Route::get('/test', function() {
    //return (int) User::find(1)->isConfined();
    return User::find(1)->unconfine();
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

    //关注和取关
    Route::post('users/follow/{user}', 'FollowsController@store')->name('follows.store');
    Route::delete('users/follow/{user}', 'FollowsController@destroy')->name('follows.destroy');

    //点赞
    Route::post('likes', 'LikesController@storeOrDestroy')->name('likes.storeOrDestroy')->middleware('auth');

    //通知
    Route::resource('notifications', 'NotificationsController', [
        'only' => ['index']
    ]);

    //禁言
    Route::post('users/{user}/confinements', 'ConfinementsController@store')->name('confinements.store');
    Route::delete('users/{user}/confinements', 'ConfinementsController@destroy')->name('confinements.destroy');
});
