<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate;

use Github\Client;
use Patate\Fetcher\PullRequestFetcher;
use Patate\Model\PhpCodeSniffer;
use Patate\Report\Report;
use Patate\Target\Target;

/**
 * Main project class.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Patate
{
    /** @var \Github\Client */
    protected $client;

    /** @var \Patate\Target\Target */
    protected $target;

    /** @var \Patate\Fetcher\PullRequestFetcher */
    protected $fetcher;

    /** @var array */
    protected $args;

    /** @var \Patate\Model\PhpCodeSniffer */
    protected $phpCodeSniffer;

    /** @var \Patate\Report\Report */
    protected $report;

    /**
     * Constructor.
     *
     * @param Client             $client         The client.
     * @param Target             $target         The target.
     * @param PullRequestFetcher $fetcher        The fetcher.
     * @param PhpCodeSniffer     $phpCodeSniffer The php code sniffer.
     * @param Report             $report         The report.
     */
    public function __construct(
        Client $client,
        Target $target,
        PullRequestFetcher $fetcher,
        PhpCodeSniffer $phpCodeSniffer,
        Report $report
    )
    {
        $this->client = $client;
        $this->target = $target;
        $this->fetcher = $fetcher;
        $this->phpCodeSniffer = $phpCodeSniffer;
        $this->report = $report;
    }

    /**
     * Gets the args.
     *
     * @return array The args.
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Sets the args.
     *
     * @param array $args The args.
     */
    public function setArgs(array $args)
    {
        $this->args = $args;
    }

    /**
     * The main process.
     */
    public function run()
    {
        $this->client->authenticate($this->args['login'], $this->args['password'], Client::AUTH_HTTP_PASSWORD);

        $this->target->setUsername($this->args['username']);
        $this->target->setRepository($this->args['repository']);
        $this->target->setPullRequestId($this->args['pull_request']);

        $files = $this->fetcher->fetch();

        $result = $this->phpCodeSniffer->run($files);

        $this->report->setReport($result);

        print $this->report->format(Report::FORMAT_TEXT);
    }
}
