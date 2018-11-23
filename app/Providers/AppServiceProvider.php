<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Carbon切换中文
        Carbon::setLocale('zh');

        //注册模型观察者
        User::observe(UserObserver::class);

        //视图公共数据
        View::share('categories', Category::allFromCache());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //IDE代码提示
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
