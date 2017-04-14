<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\ObjectBehavior;

class IncludeOnlyFilterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\IncludeOnlyFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\AbstractFilter');
    }

    public function it_filters_specification_nodes_to_include_only_given_specs(SpecificationNode $a, SpecificationNode $b, SpecificationNode $c)
    {
        $a->getTitle()->willReturn('foo1');
        $b->getTitle()->willReturn('foo2');
        $c->getTitle()->willReturn('foo3');
        $nodes = [$a, $b, $c];
        $expected = [$b];
        $this->setSpecs(['foo2']);
        $this->filter($nodes)->shouldReturn($expected);
    }
}
