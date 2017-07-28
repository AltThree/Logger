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

namespace AltThree\Tests\Logger;

use AltThree\Logger\LoggerTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * This is the logger trait test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class LoggerTraitTest extends TestCase
{
    public function testCanInstantiate()
    {
        $logger = new Logger();

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }

    /**
     * @depends testCanInstantiate
     */
    public function testCanLog()
    {
        $logger = new Logger();

        $this->expectOutputString('warning: foo');

        $logger->warning('foo');
    }
}

class Logger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, $message, array $context = [])
    {
        echo "$level: $message";
    }
}
