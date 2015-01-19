<?php

namespace spec\Humbug\PhpSpec\Loader\Filter\Example;

use PhpSpec\ObjectBehavior;

class ShuffleFilterSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Example\\ShuffleFilter');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\FilterInterface');
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Loader\\Filter\\Example\\AbstractFilter');
    }

    function it_shuffles_a_given_array()
    {
        $in = range(1, 100);
        $out = $this->filter($in);
        $out->shouldBeOutOfOrder();
    }

    public function getMatchers()
    {
        return [
            'beOutOfOrder' => function($subject) {
                return is_array($subject) && count($subject) == 100 && $subject != range(1, 100);
            }
        ];
    }

}
