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
}
