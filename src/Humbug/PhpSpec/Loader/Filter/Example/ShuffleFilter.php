<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Loader\Filter\Example;

class ShuffleFilter implements FilterInterface
{

    private $specificationTitle;

    public function filter(array $array)
    {
        shuffle($array);
        return $array;
    }

    public function setSpecificationTitle($title)
    {
        $this->specificationTitle = $title;
    }

    public function getSpecificationTitle()
    {
        return $this->specificationTitle;
    }

}