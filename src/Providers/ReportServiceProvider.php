<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Report\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/report.php', 'nw-report');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->app->make(Factory::class)->load(__DIR__.'/../../database/factories.php');

        $this->publishes([
            __DIR__.'/../../config/report.php' => config_path('nw-report.php'),
        ], 'newestapps/report');

//        $this->registerRoutes();
    }

    private function registerRoutes()
    {
//        Route::prefix('...')
//            ->middleware('some-middleware')
//            ->namespace('Newestapps\Package\Http\Controllers')
//            ->group(__DIR__.'/../../routes/package-routes.php');
    }


}