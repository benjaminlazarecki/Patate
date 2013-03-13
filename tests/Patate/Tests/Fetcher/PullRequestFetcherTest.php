<?php

/*
 * This file is part of the Patate command package.
 *
 * (c) Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Patate\Tests\Fetcher;

use Patate\Fetcher\PullRequestFetcher;

/**
 * Test for PullRequestFetcher.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class PullRequestFetcherTest extends \PHPUnit_Framework_TestCase
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
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = $this->getMock('Github\Client');
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
