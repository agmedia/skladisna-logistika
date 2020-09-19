<?php

namespace App\Providers;

use App\Models\Front\Page;
use App\Models\Front\Category\Category;
use App\Models\Front\Blog;
use App\Models\Back\Settings\Profile;
use App\Models\CategoryMenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $ttl = 60*60*2;

        // Kategorije
        $categories = Cache::rememberForever('cats', function () {
            return (new CategoryMenu())->menu();
        });
        View::share('categories', $categories);


        // Zadnje novosti
        $latest = Cache::rememberForever('latest', function () {
            return Blog::news(Category::find(45))->published()->latest()->limit(5)->get();
        });
        View::share('latest', $latest);



        // Info stranice
        /*$info_pages = Cache::rememberForever('ifp', function () {
            return Page::where('client_id', 0)->where('status', 1)->get()->groupBy('group');
        });
        View::share('info_pages', $info_pages);*/

        // App Settings - Admin
        /*view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $view->with('settings', Cache::rememberForever('app_set', function () {
                    return Profile::settings(Auth::user()->id);
                }));
            }
        });*/
    }
}
