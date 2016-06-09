<?php

namespace ElasticOxid\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SyncronizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Service\Syncronizer');
    }


}
