<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Reply;
use App\Models\Category;
use Illuminate\Notifications\DatabaseNotification as Notification;
use App\Observers\UserObserver;
use App\Observers\PostObserver;
use App\Observers\LikeObserver;
use App\Observers\ReplyObserver;
use App\Observers\CategoryObserver;
use App\Observers\NotificationObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $validators = [
        'poly_exists' => \App\Validators\PolyExistsValidator::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Carbon切换中文
        Carbon::setLocale('zh');

        //视图公共数据
        View::share('categories', Category::allFromCache());

        //注册模型观察者
        $this->registerObservers();

        //注册自建表单验证
        $this->registerValidators();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);   //IDE代码提示
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);   //快捷用户切换
        }
    }


    protected function registerObservers()
    {
        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
        Like::observe(LikeObserver::class);
        Reply::observe(ReplyObserver::class);
        Category::observe(CategoryObserver::class);
        Notification::observe(NotificationObserver::class);
    }


    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            \Validator::extend($rule, "{$validator}@validate");
        }
    }
}
