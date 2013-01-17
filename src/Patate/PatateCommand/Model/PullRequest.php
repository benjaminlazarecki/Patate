<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\PatateCommand\Model;

use Github\Api\Issue;
use Github\Client;
use Github\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Model for a pull request command.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class PullRequest
{
    /** @var \Symfony\Component\Console\Input\InputInterface */
    protected $input;

    /** @var boolean */
    protected $errors;

    /** @var string */
    protected $report;

    /** @var string */
    protected $message;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input The command input.
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
        $this->errors = false;
        $this->report = '';
        $this->message = '';
    }

    /**
     * Return TRUE if pull request has errors, else FALSE.
     *
     * @return bool TRUE if pull request has errors, else FALSE.
     */
    public function hasErrors()
    {
        return $this->report !== '';
    }

    /**
     * Return phpcs reports.
     *
     * @return string The phphcs report.
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Return the message for command output and pull request command.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Check all pull request file with phpcs.
     */
    public function process()
    {
        $username = $this->input->getArgument('username');
        $repository = $this->input->getArgument('repository');
        $pullRequestId = $this->input->getArgument('pull-request');
        $login = $this->input->getOption('login');
        $password = $this->input->getOption('password');
        $noComment = $this->input->getOption('no-comment');

        $client = new Client();
        $client->setHeaders(array(
            'Accept: application/vnd.github-blob.raw'
        ));

        if ($password !== null) {
            $client->authenticate($login, $password, Client::AUTH_HTTP_PASSWORD);
        }

        $pullRequest = $client->api('pull_requests')->show($username, $repository, $pullRequestId);

        $files = $client->api('pr')->files($username, $repository, $pullRequestId);

        foreach ($files as $file) {
            $filename = $file['filename'];
            $extension = explode('.', $filename)[count(explode('.', $filename)) - 1];
            if ($extension === 'php') {
                $fileContent = $client->getHttpClient()->get(sprintf('repos/%s/%s/contents/%s?ref=%s',
                    $username,
                    $repository,
                    $file['filename'],
                    $pullRequest['head']['sha']
                ));

                $tmpFileName = uniqid('file_');
                file_put_contents('/tmp/'.$tmpFileName, $fileContent->getContent());

                $result = array();
                exec("phpcs /tmp/$tmpFileName", $result);
                unlink('/tmp/' . $tmpFileName);

                array_shift($result);
                if (!empty($result)) {
                    $this->report .= implode("\r\n", $result);
                }
            }
        }

        if ($this->hasErrors()) {
            $message = 'Sorry! There are some problems' . PHP_EOL;
            $message .= $this->getReport();

            if (!$noComment) {
                /* @var \Github\Api\Issue\PullRequest\Comments $comments */
                $comments = $client->api('pull_request')->comments();
                $comments->create($username, $repository, $pullRequestId, array('body' => $this->getReport()));
            }
        } else {
            $message = 'Yeah! There is no problems';
        }

        $this->message = $message;
    }
}
