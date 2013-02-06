<?php

namespace Patate\Tests\Target;

use Github\Exception\InvalidArgumentException;
use Patate\Target\Target;

/**
 * Test for Target.
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class TargetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Patate\Target\Target
     */
    protected $target;

    public function setUp()
    {
        $this->target = new Target();
    }

    public function testGetSetUsername()
    {
        $this->assertNull($this->target->getUsername());

        $this->target->setUsername('foo');
        $this->assertSame('foo', $this->target->getUsername());
    }

    public function testGetSetRepository()
    {
        $this->assertNull($this->target->getRepository());

        $this->target->setRepository('foo');
        $this->assertSame('foo', $this->target->getRepository());
    }

    public function testGetSetPullRequestId()
    {
        $this->assertNull($this->target->getPullRequestId());

        $this->target->setPullRequestId(1);
        $this->assertSame(1, $this->target->getPullRequestId());
    }
}
