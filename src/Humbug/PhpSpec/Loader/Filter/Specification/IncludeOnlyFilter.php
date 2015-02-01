<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Loader\Filter\Specification;

use PhpSpec\Loader\Node\SpecificationNode;

class IncludeOnlyFilter extends AbstractFilter
{

    private $specs;

    public function filter(array $array)
    {
        $include = [];
        foreach ($array as $value) {
            if (in_array($value->getTitle(), $this->specs)) {
                $include[] = $value;
            }
        }
        return $include;
    }

    public function setSpecs(array $specs)
    {
        $this->specs = $specs;
    }
}
