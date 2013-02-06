<?php

namespace Patate\Tests\Client;

use Patate\Client\Client;

/**
 *
 *
 * @author Benjamin Lazarecki <benjamin.lazarecki@gmail.com>
 */
class ClientTest
{
    public function testConstructor()
    {
        $client = new Client();

        var_dump($client);
    }
}
