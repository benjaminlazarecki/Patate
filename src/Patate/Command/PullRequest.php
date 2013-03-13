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

use Patate\Patate;
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
    /** @var \Patate\Patate */
    protected $patate;

    /**
     * {@inheritdoc}
     *
     * @param Patate $patate The patate.
     */
    public function __construct($name, Patate $patate)
    {
        parent::__construct(null);

        $this->patate = $patate;
    }

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
            ->addOption('login', null, InputOption::VALUE_REQUIRED, 'Your login');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $password = $dialog->askHiddenResponse($output, 'Password: ');

        $this->patate->setArgs(array(
            'username'     => $input->getArgument('username'),
            'repository'   => $input->getArgument('repository'),
            'pull_request' => $input->getArgument('pull-request'),
            'login'        => $input->getOption('login'),
            'password'     => $password,
        ));

        $this->patate->run();
    }
}
