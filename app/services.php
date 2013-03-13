<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

use Github\Client;
use Patate\Command\PullRequest;
use Patate\Fetcher\PullRequestFetcher;
use Patate\Model\PhpCodeSniffer;
use Patate\Patate;
use Patate\Report\Report;
use Patate\Storage\Filesystem;
use Patate\Target\Target;
use Symfony\Component\Console\Application;

$container['patate'] = $container->share(function (Pimple $container) {
    return new Patate(
        $container['client'],
        $container['target'],
        $container['fetcher'],
        $container['code_sniffer'],
        $container['report']
    );
});

$container['app'] = $container->share(function (Pimple $container) {
    $app = new Application();
    $app->add($container['app.pull_request']);

    return $app;
});

$container['app.pull_request'] = $container->share(function (Pimple $container) {
    return new PullRequest(null, $container['patate']);
});

$container['client'] = $container->share(function (Pimple $container) {
    $client = new Client();
    $client->setHeaders($container['client.headers']);

    return $client;
});

$container['target'] = $container->share(function () {
    return new Target();
});

$container['fetcher'] = $container->share(function (Pimple $container) {
    return new PullRequestFetcher($container['client'], $container['target']);
});

$container['filesystem'] = $container->share(function () {
    return new Filesystem();
});

$container['code_sniffer'] = $container->share(function (Pimple $container) {
    return new PhpCodeSniffer($container['filesystem']);
});

$container['report'] = $container->share(function () {
    return new Report();
});
