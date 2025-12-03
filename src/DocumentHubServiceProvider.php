<?php
namespace Versatecnologia\DocumentHub;

use Illuminate\Support\ServiceProvider;
use Versatecnologia\DocumentHub\DocumentHub as VersatecnologiaDocumentHub;

class DocumentHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('document-hub', function ($app) {
            return new VersatecnologiaDocumentHub();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/document-hub.php', 'document-hub'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/document-hub.php' => config_path('document-hub.php'),
            ], 'document-hub-config');
        }
    }
}