<?php

declare(strict_types=1);

/*
 * This file is part of Alt Three Logger.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AltThree\Logger;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
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
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/logger.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('logger.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('logger');
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
        $this->registerLogger();
    }

    /**
     * Register the logger class.
     *
     * @return void
     */
    protected function registerLogger()
    {
        $this->app->singleton('logger', function (Container $app) {
            $loggers = [];

            foreach ($app->config->get('logger.loggers', []) as $logger => $levels) {
                $loggers[] = new LevelAwareLogger($app->make($logger), (array) $levels);
            }

            return new LoggerWrapper($loggers);
        });

        $this->app->alias('logger', LoggerWrapper::class);
        $this->app->alias('logger', LoggerInterface::class);
        $this->app->alias('logger', Log::class);
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
