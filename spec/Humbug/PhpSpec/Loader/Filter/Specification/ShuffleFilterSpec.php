<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\ObjectBehavior;

class ShuffleFilterSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\ShuffleFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Specification\\FilterInterface');
    }

    function it_shuffles_a_given_array()
    {
        $in = range(1, 100);
        $out = $this->filter($in);
        $out->shouldBeOutOfOrder($out);
    }

    public function getMatchers()
    {
        return [
            'beOutOfOrder' => function($subject, $value) {
                return is_array($value) && count($value) == 100 && $value != range(1, 100);
            }
        ];
    }

}
