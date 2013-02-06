<?php

namespace Patate\Tests\Fetcher;

/**
 * Test for PullRequestFetcher.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
use Patate\Fetcher\PullRequestFetcher;

class PullRequestFetcherTest extends \PHPUnit_Framework_TestCase
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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = $this->getMock('Patate\Client\Client');
        $this->target = $this->getMock('Patate\Target\Target');
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->client);
        unset($this->target);
    }

    public function testGetClient()
    {
        $fetcher = new PullRequestFetcher($this->client, $this->target);

        $this->assertSame($this->client, $fetcher->getClient());
    }

    public function testGetTarget()
    {
        $fetcher = new PullRequestFetcher($this->client, $this->target);

        $this->assertSame($this->target, $fetcher->getTarget());
    }

    //public function testFetch()
    //{
        //$this
            //->target
            //->expects($this->any())
            //->method('getUsername')
            //->with($this->equalTo('username'));

        //$this
            //->target
            //->expects($this->any())
            //->method('getRepository')
            //->with($this->equalTo('repository'));

        //$this
            //->target
            //->expects($this->any())
            //->method('getPullRequestId')
            //->with($this->equalTo(1));

        //$this
            //->client
            //->expects($this->any())
            //->method('api')
            //->with($this->equalTo('pull_requests'));

        //$fetcher = new PullRequestFetcher($this->client, $this->target);

        //$this->assertSame('ok', $fetcher->fetch());
    //}
}
