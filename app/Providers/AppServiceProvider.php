<?php

namespace App\Providers;

use App\Models\SiteContent;
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
        try {
            $content = SiteContent::pluck('value', 'key')->toArray();
        } catch (\Exception) {
            $content = [];
        }

        view()->share('content', $content);
    }
}
