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

use Patate\Command\PullRequest;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PullRequest());
$application->run();
