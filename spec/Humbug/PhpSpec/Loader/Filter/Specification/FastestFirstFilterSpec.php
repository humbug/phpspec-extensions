<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\ObjectBehavior;
use PhpSpec\Loader\Node\SpecificationNode;

class FastestFirstFilterSpec extends ObjectBehavior
{

    function let()
    {
        file_put_contents(
            sys_get_temp_dir() . '/phpspec.times.humbug.json',
            json_encode([
                'specifications' => [
                    'foo1' => 3,
                    'foo2' => 2,
                    'foo3' => 1,
                ],
                'examples' => []
            ])
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\FastestFirstFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\AbstractFilter');
    }

    function it_shuffles_a_given_array(SpecificationNode $a, SpecificationNode $b, SpecificationNode $c)
    {
        $a->getTitle()->willReturn('foo1');
        $b->getTitle()->willReturn('foo2');
        $c->getTitle()->willReturn('foo3');
        $nodes = [$a, $b, $c];
        $expected = [$c, $b, $a];
        $this->filter($nodes)->shouldReturn($expected);
    }

}
