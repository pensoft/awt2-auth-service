<?php

namespace App\Providers;

use App\Services\MicroserviceConnectorService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('FORCE_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
        $this->app->bind(MicroserviceConnectorService::class, function () {
            return new MicroserviceConnectorService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(env('FORCE_HTTPS')) {
            $url->forceScheme('https');
        }
    }
}
