<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Loader\Filter\Example;

class ShuffleFilter extends AbstractFilter
{
    public function filter(array $array)
    {
        shuffle($array);

        return $array;
    }
}
