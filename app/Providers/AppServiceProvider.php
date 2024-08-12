<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

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
        \DB::statement("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
        class_alias('App\\Http\\Helpers\\HelperController', 'Help', true);
        class_alias('App\\Api\\Helpers\\Amele', 'Amele', true);
        class_alias('App\\Helpers\\BasketService', 'BasketService', true);

    }
}
