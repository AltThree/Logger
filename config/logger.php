<?php

/*
 * This file is part of Alt Three Logger.
 *
 * (c) Alt Three LTD <support@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Loggers
    |--------------------------------------------------------------------------
    |
    | Here are each of the loggers to call under the hood while logging.
    |
    */

    'loggers' => [
        'Illuminate\Log\Writer' => ['*'],
    ],

];
