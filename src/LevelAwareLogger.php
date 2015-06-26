<?php

/*
 * This file is part of Alt Three Logger.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AltThree\Logger;

use Illuminate\Contracts\Logging\Log;
use Psr\Log\LoggerInterface;

/**
 * This is the level aware logger class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LevelAwareLogger implements LoggerInterface, Log
{
    use LoggerTrait;

    /**
     * The underlying logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * The levels to log.
     *
     * @var string[]
     */
    protected $levels;

    /**
     * Create a new level aware logger instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param string[]                 $levels
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger, array $levels)
    {
        $this->logger = $logger;
        $this->levels = $levels;
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
        if ($this->shouldLog($level)) {
            $this->logger->log($level, $this->formatMessage($message), $context);
        }
    }

    /**
     * Should the message be logged?
     *
     * @param string $level
     *
     * @return bool
     */
    protected function shouldLog($level)
    {
        if ($this->levels === ['*'] || $this->levels === ['all']) {
            return true;
        }

        return in_array($level, $this->levels);
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
        if ($this->logger instanceof Log) {
            $this->logger->useFiles($path, $level);
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
        if ($this->logger instanceof Log) {
            $this->logger->useDailyFiles($path, $days, $level);
        }
    }
}
