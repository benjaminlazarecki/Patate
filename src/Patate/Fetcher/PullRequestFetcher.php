<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Fetcher;

use Github\Client;
use Github\Exception\RuntimeException;
use Patate\Target\Target;

/**
 * Fetch file content for a pull request.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PullRequestFetcher
{
    /**
     * @var \Github\Client
     */
    protected $client;

    /**
     * @var \Patate\Target\Target
     */
    protected $target;

    /**
     * Constructor.
     *
     * @param \Github\Client        $client The client.
     * @param \Patate\Target\Target $target The target.
     */
    public function __construct(Client $client, Target $target)
    {
        $this->client = $client;
        $this->target = $target;
    }

    /**
     * Gets the client.
     *
     * @return \Github\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Gets the target.
     *
     * @return \Github\Client
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch()
    {
        $username = $this->getTarget()->getUsername();
        $repository = $this->getTarget()->getRepository();
        $pullRequestId = $this->getTarget()->getPullRequestId();

        $pullRequest = $this->getClient()->api('pull_requests')->show($username, $repository, $pullRequestId);
        $files = $this->getClient()->api('pr')->files($username, $repository, $pullRequestId);

        $contents = array();
        foreach ($files as $file) {
            $filename = $file['filename'];
            $extension = explode('.', $filename);
            $extension = $extension[count(explode('.', $filename)) - 1];

            if ($extension !== 'php') {
                continue;
            }

            try {
                $contents[$filename] = $this->getClient()->getHttpClient()->get(sprintf('repos/%s/%s/contents/%s?ref=%s',
                    $username,
                    $repository,
                    $filename,
                    $pullRequest['head']['sha']
                ))->getContent();
            } catch (RuntimeException $e) {
            }
        }

        return $contents;
    }
}
