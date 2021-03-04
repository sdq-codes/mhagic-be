<?php


namespace App\Providers;

use App\Adapter\Interfaces\SmsAdapterInterface;
use App\Adapter\SmsAdapter;
use App\Services\Interfaces\SmsServiceInterface;
use App\Services\SmsServices;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {
        /**Register Observer Models **/

        # register the routes

    }

    public function register()
    {
        //
        $this->app->bind(
            SmsAdapterInterface::class,
            SmsAdapter::class
        );

        $this->app->bind(
            SmsServiceInterface::class,
            SmsServices::class
        );
    }
}
