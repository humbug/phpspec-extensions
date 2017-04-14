<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Example;

use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\ObjectBehavior;

class FastestFirstFilterSpec extends ObjectBehavior
{
    public function let()
    {
        file_put_contents(
            sys_get_temp_dir().'/phpspec.times.humbug.json',
            json_encode([
                'specifications' => [
                ],
                'examples' => [
                    'foo' => [
                        [
                            'title' => 'bar1',
                            'time'  => 3,
                        ],
                        [
                            'title' => 'bar2',
                            'time'  => 2,
                        ],
                        [
                            'title' => 'bar3',
                            'time'  => 1,
                        ],
                    ],
                ],
            ])
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Example\\FastestFirstFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Example\\AbstractFilter');
    }

    public function it_orders_an_array_of_example_nodes(ExampleNode $a, ExampleNode $b, ExampleNode $c)
    {
        $a->getTitle()->willReturn('bar1');
        $b->getTitle()->willReturn('bar2');
        $c->getTitle()->willReturn('bar3');
        $nodes = [$a, $b, $c];
        $expected = [$c, $b, $a];
        $this->setSpecificationTitle('foo');
        $this->filter($nodes)->shouldReturn($expected);
    }
}
