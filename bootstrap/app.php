<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

 $app->withFacades();

 $app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');
$app->configure('sentry');
$app->configure('cors');
$app->configure('database');
$app->configure('system');
$app->configure('jwt');
$app->configure('filesystems');
$app->configure('queue');
$app->configure('mail');
$app->configure('services');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

 $app->middleware([
     'Nord\Lumen\Cors\CorsMiddleware',

 ]);

 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
     'is_verified' => \App\Http\Middleware\IsVerified::class
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

 $app->register(App\Providers\AppServiceProvider::class);
 $app->register(App\Providers\AuthServiceProvider::class);
 $app->register(App\Providers\EventServiceProvider::class);
 $app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
 $app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
 $app->register(Spatie\Permission\PermissionServiceProvider::class);
 $app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
 $app->register(Sentry\Laravel\ServiceProvider::class);
 $app->register('Nord\Lumen\Cors\CorsServiceProvider');
 $app->register(LaravelFCM\FCMServiceProvider::class);
 $app->register(\App\Providers\ResponseServiceProvider::class);
 $app->register(\App\Providers\RepositoriesServiceProvider::class);
 $app->register(\Illuminate\Mail\MailServiceProvider::class);
 $app->register(\Illuminate\Notifications\NotificationServiceProvider::class);
 $app->register(\Fedeisas\LaravelMailCssInliner\LaravelMailCssInlinerServiceProvider::class);



 $app->alias('cache', 'Illuminate\Cache\CacheManager');
 $app->alias('auth', 'Illuminate\Auth\AuthManager');
 $app->alias('mail.manager', Illuminate\Mail\MailManager::class);
 $app->alias('mail.manager', Illuminate\Contracts\Mail\Factory::class);
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
