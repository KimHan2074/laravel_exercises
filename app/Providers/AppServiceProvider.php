<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TypeProduct;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('header', function ($view) {				
            $categories = TypeProduct::all();				
            $view->with('categories', $categories);				
        });				                   
    }
}
