<?php

namespace ElasticOxid\Connector;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Connector\Connector');
    }

    function let()
    {
        $config = [
            'host'            => null,
            'port'            => null,
            'path'            => null,
            'url'             => null,
            'proxy'           => null,
            'transport'       => null,
            'persistent'      => true,
            'timeout'         => null,
            'connections'     => array(),
            'roundRobin'      => false,
            'log'             => false,
            'retryOnConflict' => 0
        ];
        $this->beConstructedWith($config);
    }
}
