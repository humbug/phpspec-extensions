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

class JsonTimeLogger
{
    private $specifications = [];

    private $examples = [];

    private $target;

    public function __construct($target = null)
    {
        if (null !== $target) {
            $this->target = $target;

            return;
        }
        $this->target = sys_get_temp_dir().'/phpspec.times.humbug.json';
    }

    public function logSpecification($title, $time)
    {
        $this->specifications[$title] = $time;
    }

    public function logExample($spec, $title, $time)
    {
        if (!isset($this->examples[$spec])) {
            $this->examples[$spec] = [];
        }
        $this->examples[$spec][] = [
            'title' => $title,
            'time'  => $time,
        ];
    }

    public function write()
    {
        file_put_contents(
            $this->target,
            json_encode(
                [
                    'specifications' => $this->specifications,
                    'examples'       => $this->examples,
                ],
                JSON_PRETTY_PRINT
            )
        );
    }
}
