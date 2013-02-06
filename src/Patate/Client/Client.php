<?php

namespace Patate\Client;

use Github\Client as BaseClient;
use Github\HttpClient\HttpClientInterface;

/**
 * Represent a github client.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * {@inheritdoc}
     *
     * Add specific header for non crypt content.
     *
     * @link http://developer.github.com/v3/media/
     */
    public function __construct(HttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->setHeaders(array('Accept: application/vnd.github-blob.raw'));
    }
}
