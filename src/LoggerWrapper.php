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

use Illuminate\Contracts\Logging\Log;
use Psr\Log\LoggerInterface;

/**
 * This is the logger wrapper class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LoggerWrapper implements LoggerInterface, Log
{
    use LoggerTrait;

    /**
     * The registered loggers.
     *
     * @var \Illuminate\Contracts\Logging\Log[]
     */
    protected $loggers;

    /**
     * Create a new logger wrapper instance.
     *
     * @param \Illuminate\Contracts\Logging\Log[] $loggers
     *
     * @return void
     */
    public function __construct(array $loggers)
    {
        $this->loggers = $loggers;
    }

    /**
     * Log a message to the logs.
     *
     * @param string $level
     * @param mixed  $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        foreach ($this->loggers as $logger) {
            $logger->log($level, $this->formatMessage($message), $context);
        }
    }

    /**
     * Register a file log handler.
     *
     * @param string $path
     * @param string $level
     *
     * @return void
     */
    public function useFiles($path, $level = 'debug')
    {
        foreach ($this->loggers as $logger) {
            $logger->useFiles($path, $level);
        }
    }

    /**
     * Register a daily file log handler.
     *
     * @param string $path
     * @param int    $days
     * @param string $level
     *
     * @return void
     */
    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
        foreach ($this->loggers as $logger) {
            $logger->useDailyFiles($path, $days, $level);
        }
    }
}
