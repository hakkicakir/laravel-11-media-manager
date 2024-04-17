<?php

namespace Hcakir\Laravel11MediaManager\Providers;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->publishes([
            __DIR__.'/../../src/database/migrations' => database_path('migrations'),
           
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../src/tests' => base_path('tests'),
        ], 'tests');

       
        $this->commands([
            \Illuminate\Foundation\Console\VendorPublishCommand::class,
        ]);
    }
}
