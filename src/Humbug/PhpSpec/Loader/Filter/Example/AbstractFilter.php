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

use Humbug\PhpSpec\Loader\Filter\FilterInterface as BaseInterface;

abstract class AbstractFilter implements BaseInterface
{

    private $specificationTitle;

    public function setSpecificationTitle($title)
    {
        $this->specificationTitle = $title;
    }

    public function getSpecificationTitle()
    {
        return $this->specificationTitle;
    }
}
