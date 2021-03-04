<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BryanskPortalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }
    public function register()
    {
        $this->app->singleton('BryanskPortal', function() {
            return new \App\BryanskPortal;
        });
    }
}
