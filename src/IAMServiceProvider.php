<?php

namespace NextDeveloper\IAM;

use Illuminate\Support\Facades\Auth;
use NextDeveloper\Commons\AbstractServiceProvider;
use NextDeveloper\IAM\Auth\Providers\IamUserProvider;

/**
 * Class IAMServiceProvider
 *
 * @package NextDeveloper\IAM
 */
class IAMServiceProvider extends AbstractServiceProvider {
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            __DIR__.'/../config/iam.php' => config_path('iam.php'),
        ], 'config');

        $this->loadViewsFrom($this->dir.'/../resources/views', 'IAM');

//        $this->bootErrorHandler();
        $this->bootGuard();
        $this->bootChannelRoutes();
        $this->bootModelBindings();
        $this->bootEvents();
        $this->bootLogger();
    }

    public function bootGuard() {

    }

    /**
     * @return void
     */
    public function register() {
        $this->registerHelpers();
        $this->registerMiddlewares('generator');
        $this->registerRoutes();
        $this->registerCommands();

        $this->mergeConfigFrom(__DIR__.'/../config/iam.php', 'iam');
        $this->customMergeConfigFrom(__DIR__.'/../config/relation.php', 'relation');
    }

    /**
     * @return void
     */
    public function bootLogger() {
//        $monolog = Log::getMonolog();
//        $monolog->pushProcessor(new \Monolog\Processor\WebProcessor());
//        $monolog->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor());
//        $monolog->pushProcessor(new \Monolog\Processor\MemoryPeakUsageProcessor());
    }

    /**
     * @return array
     */
    public function provides() {
        return ['generator'];
    }

//    public function bootErrorHandler() {
//        $this->app->singleton(
//            ExceptionHandler::class,
//            Handler::class
//        );
//    }

    /**
     * @return void
     */
    private function bootChannelRoutes() {
        if (file_exists(($file = $this->dir.'/../config/channel.routes.php'))) {
            require_once $file;
        }
    }

    /**
     * @return void
     */
    protected function bootEvents() {
        $configs = config()->all();

        foreach ($configs as $key => $value) {
            if (config()->has($key.'.events')) {
                foreach (config($key.'.events') as $event => $handlers) {
                    foreach ($handlers as $handler) {
                        $this->app['events']->listen($event, $handler);
                    }
                }
            }
        }
    }

    /**
     * Register module routes
     *
     * @return void
     */
    protected function registerRoutes() {
        if ( ! $this->app->routesAreCached() && config('leo.allowed_routes.iam', true) ) {
            $this->app['router']
                ->namespace('NextDeveloper\IAM\Http\Controllers')
                ->group(__DIR__.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'api.routes.php');
        }
    }

    /**
     * Registers module based commands
     * @return void
     */
    protected function registerCommands() {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }
    }

    /**
     * This is here, in case of shit happens!
     * @return void
     */
    private function checkDatabaseConnection() {
        $isSuccessfull = false;

        try {
            \DB::connection()->getPdo();

            $isSuccessfull = true;
        } catch (\Exception $e) {
            die('Could not connect to the database. Please check your configuration. error:'.$e);
        }

        return $isSuccessfull;
    }
    // EDIT AFTER HERE - WARNING: ABOVE THIS LINE MAY BE REGENERATED AND YOU MAY LOSE CODE
}
