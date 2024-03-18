<?php

namespace App\Providers;


use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        //
        Paginator::useBootstrap();
             view()->composer(
            'layouts.dashboard',
            function ($view) {
                $view->with('user', User::all()->where('type', 'admin'));
                // $view->with('user', User::all()->where('type', 'admin'), 'posts', Post::all());

            }
        );

    }
}
