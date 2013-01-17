<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\PatateCommand\Command;

use Patate\PatateCommand\Model\PullRequest as Process;
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
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'Your password')
            ->addOption('no-comment', null, InputOption::VALUE_NONE, 'If set the report will not be comment');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pullRequest = new Process($input);

        try {
            $pullRequest->process();
        } catch (RuntimeException $e) {
            $output->writeln('<error>Sorry! There is a problem with your command. Plz check your args</error>');

            die;
        }

        if ($pullRequest->hasErrors()) {
            $output->writeln(sprintf('<error>%s</error>', $pullRequest->getMessage()));
            $output->write($pullRequest->getReport());
        } else {
            $output->writeln(sprintf('<info>%s</info>', $pullRequest->getMessage()));
        }
    }
}
