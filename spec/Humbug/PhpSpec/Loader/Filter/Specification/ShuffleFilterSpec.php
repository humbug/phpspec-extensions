<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\ObjectBehavior;

class ShuffleFilterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\ShuffleFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\AbstractFilter');
    }

    public function it_shuffles_a_given_array()
    {
        $in = range(1, 100);
        $out = $this->filter($in);
        $out->shouldBeOutOfOrder();
    }

    public function getMatchers()
    {
        return [
            'beOutOfOrder' => function ($subject) {
                return is_array($subject) && count($subject) == 100 && $subject != range(1, 100);
            },
        ];
    }
}
