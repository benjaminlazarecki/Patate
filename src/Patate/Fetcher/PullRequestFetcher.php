<?php

namespace Patate\Fetcher;

use Patate\Client\Client;
use Patate\Target\Target;

/**
 * Fetch file content for a pull request.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PullRequestFetcher
{
    /**
     * @var \Patate\Client\Client
     */
    protected $client;

    /**
     * @var \Patate\Target\Target
     */
    protected $target;

    /**
     * Constructor.
     *
     * @param \Patate\Client\Client $client The client.
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
     * @return \Patate\Client\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Gets the target.
     *
     * @return \Patate\Target\Target
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
            $extension = explode('.', $filename)[count(explode('.', $filename)) - 1];

            if ($extension !== 'php') {
                continue;
            }

            $contents[] = $this->getClient()->getHttpClient()->get(sprintf('repos/%s/%s/contents/%s?ref=%s',
                $username,
                $repository,
                $file['filename'],
                $pullRequest['head']['sha']
            ));
        }

        return $contents;
    }
}
