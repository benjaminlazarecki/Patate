<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Command;

use Patate\Fetcher\PullRequestFetcher;
use Patate\Model\PhpCodeSniffer;
use Patate\Report\PhpCsReport;
use Patate\Storage\Filesystem;
use Patate\Target\Target;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Github\Client;

/**
 * Check a pull request and comment if there are some errors.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class PullRequest extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('pull-request')
            ->setDescription('Execute PHP_CodeSniffer on pull request and comment it if there are errors')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('repository', InputArgument::REQUIRED, 'The repository')
            ->addArgument('pull-request', InputArgument::REQUIRED, 'The pull request number')
            ->addOption('login', null, InputOption::VALUE_REQUIRED, 'Your login')
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'Your password');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $repository = $input->getArgument('repository');
        $pullRequestId = $input->getArgument('pull-request');
        $login = $input->getOption('login');
        $password = $input->getOption('password');

        $client = new \Patate\Client\Client();
        $client->authenticate($login, $password, Client::AUTH_HTTP_PASSWORD);

        $target = new Target();
        $target
            ->setUsername($username)
            ->setRepository($repository)
            ->setPullRequestId($pullRequestId);

        $prFetcher = new PullRequestFetcher($client, $target);
        $contents = $prFetcher->fetch();

        $fs = new Filesystem();
        $fs->writeAll($contents);

        $phpcs = new PhpCodeSniffer();
        $results = $phpcs->execute($fs->getIdentifiers());

        $report = new PhpCsReport($results);

        echo $report->format('text');

        $fs->clearAll();
    }
}
