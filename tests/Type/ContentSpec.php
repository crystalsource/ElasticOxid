<?php

namespace ElasticOxid\Type;

use ElasticOxid\Connector\Connector;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentSpec extends ObjectBehavior
{
    function let(Connector $connector)
    {
        $this->beConstructedWith($connector);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Type\Content');
        $this->shouldImplement('ElasticOxid\Type\Type');
    }
}
