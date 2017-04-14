<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Logger;

class JsonSpecMapLogger
{
    private $classes = [];

    private $target;

    public function __construct($target = null)
    {
        if (null !== $target) {
            $this->target = $target;

            return;
        }
        $this->target = sys_get_temp_dir().'/phpspec.specmap.humbug.json';
    }

    public function logSpecification($srcFile, $specTitle, $specClass, $srcClass)
    {
        $this->classes[$srcFile] = [
            'specTitle' => $specTitle,
            'specClass' => $specClass,
            'srcClass'  => $srcClass,
        ];
    }

    public function write()
    {
        file_put_contents(
            $this->target,
            json_encode(
                $this->classes,
                JSON_PRETTY_PRINT
            )
        );
    }
}
