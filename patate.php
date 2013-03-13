#!/usr/bin/env php
<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

include_once 'vendor/autoload.php';

/* START CONTAINER */

$container = new Pimple();

require __DIR__ . '/app/config.php';
require __DIR__ . '/app/services.php';

/* END CONTAINER */

/* @var \Symfony\Component\Console\Application $app */
$app = $container['app'];
$app->run();
