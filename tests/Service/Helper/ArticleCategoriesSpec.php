<?php

namespace ElasticOxid\Service\Helper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArticleCategoriesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ElasticOxid\Service\Helper\ArticleCategories');
    }
}
