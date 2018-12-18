<?php

namespace App\Providers;

use App\Models\Confinement;
use Carbon\Carbon;
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
        View::share('categories', \App\Models\Category::allFromCache());

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
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Like::observe(\App\Observers\LikeObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Confinement::observe(\App\Observers\ConfinementObserver::class);

        \Illuminate\Notifications\DatabaseNotification::observe(\App\Observers\NotificationObserver::class);
    }


    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            \Validator::extend($rule, "{$validator}@validate");
        }
    }
}
