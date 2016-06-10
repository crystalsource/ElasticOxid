<?php

namespace ElasticOxid\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Service\Loader');
    }
}
