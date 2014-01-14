<?php

/*
 * This file is part of plusminus-parser.
 *
 * (c) Alexander <iam.asm89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (file_exists($file = __DIR__.'/../vendor/autoload.php')) {
    $loader = require_once $file;
    $loader->add('Asm89', __DIR__);
} else {
    throw new RuntimeException('Install dependencies to run test suite.');
}

