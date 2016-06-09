<?php

namespace ElasticOxid\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefaultTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Type\DefaultType');
        $this->shouldImplement('ElasticOxid\Type\Type');

    }
}
