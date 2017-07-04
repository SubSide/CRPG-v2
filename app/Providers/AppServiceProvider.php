<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        // Give all views page data

        View::composer('*', function ($view) {
            $menuPages = Page::select('id', 'title')
                ->where('type', \App\Models\PageType::PAGE)
                ->where('id', '!=', 1)
                ->orderBy('title', 'DESC');
            if (!Auth::check()) $menuPages->where('logged_in', 0);
            $menuPages = $menuPages->get();

            $resourcePages = Page::select('id', 'title')
                ->where('type', \App\Models\PageType::RESOURCE)
                ->where('id', '!=', 1)
                ->orderBy('title', 'DESC');
            if (!Auth::check()) $resourcePages->where('logged_in', 0);
            $resourcePages = $resourcePages->get();

            $view->with('menuPages', $menuPages);
            $view->with('resourcePages', $resourcePages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
