<?php

/*
 * This file is part of Alt Three Logger.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AltThree\Logger;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

/**
 * This is the logger service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/logger.php');

        if (class_exists('Illuminate\Foundation\Application', false) && $app->runningInConsole()) {
            $this->publishes([$source => config_path('logger.php')]);
        } elseif (class_exists('Laravel\Lumen\Application', false)) {
            $app->configure('logger');
        }

        $this->mergeConfigFrom($source, 'logger');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogger($this->app);
    }

    /**
     * Register the logger class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerLogger(Application $app)
    {
        $app->singleton('logger', function ($app) {
            $loggers = [];

            foreach ($app->config->get('logger.loggers', []) as $logger => $levels) {
                $loggers[] = new LevelAwareLogger($app->make($logger), (array) $levels);
            }

            return new LoggerWrapper($loggers);
        });

        $app->alias('logger', LoggerWrapper::class);
        $app->alias('logger', LoggerInterface::class);
        $app->alias('logger', Log::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'logger',
        ];
    }
}
