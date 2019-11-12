<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// xss需要注册这个类 普通的表单域里面
use App\Observers\UserObserver;
use App\Observers\TopicObserver;
use App\Observers\ReplyObserver;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Topic::observe(TopicObserver::class);
        User::observe(UserObserver::class);
        Reply::observe(ReplyObserver::class);
    }
}
