<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\Loader\Node\SpecificationNode;
use PhpSpec\ObjectBehavior;

class FastestFirstFilterSpec extends ObjectBehavior
{
    public function let()
    {
        file_put_contents(
            sys_get_temp_dir().'/phpspec.times.humbug.json',
            json_encode([
                'specifications' => [
                    'foo1' => 3,
                    'foo2' => 2,
                    'foo3' => 1,
                ],
                'examples' => [],
            ])
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\FastestFirstFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\AbstractFilter');
    }

    public function it_orders_an_array_of_specification_nodes(SpecificationNode $a, SpecificationNode $b, SpecificationNode $c)
    {
        $a->getTitle()->willReturn('foo1');
        $b->getTitle()->willReturn('foo2');
        $c->getTitle()->willReturn('foo3');
        $nodes = [$a, $b, $c];
        $expected = [$c, $b, $a];
        $this->filter($nodes)->shouldReturn($expected);
    }
}
