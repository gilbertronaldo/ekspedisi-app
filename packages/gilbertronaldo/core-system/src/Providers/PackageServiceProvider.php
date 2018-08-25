<?php

namespace GilbertRonaldo\CoreSystem\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider
 * @package GilbertRonaldo\CoreSystem\Providers
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . '/../define.php';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
