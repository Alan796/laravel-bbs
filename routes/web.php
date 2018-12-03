<?php
use App\Models\User;
use App\Models\Reply;

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

//帖子和回复
Route::resource('categories', 'CategoriesController', [
    'only' => ['show']
]);
Route::resource('posts', 'PostsController', [
    'except' => ['show']
]);
Route::get('posts/{post}/{slug?}', 'PostsController@show')->name('posts.show');
Route::post('posts/image', 'PostsController@imageStore')->name('posts.image_store');    //发帖时上传图片
Route::resource('replies', 'RepliesController', [
    'only' => ['show', 'store', 'destroy']
]);


//测试
Route::get('/test', function() {
    User::find(1)->follow([1, 2, 3, 4]);
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

    //点赞
    Route::post('likes', 'LikesController@storeOrDestroy')->name('likes.storeOrDestroy')->middleware('auth');
});
