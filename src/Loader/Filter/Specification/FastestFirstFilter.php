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

class FastestFirstFilter implements FilterInterface
{

    private $log;

    public function filter(array &$array)
    {
        $times = $this->loadTimes();
        asort($times['specifications'], SORT_NUMERIC);
        usort($array, function (SpecificationNode $a, SpecificationNode $b) use (&$times) {
            if ($times['specifications'][$a->getTitle()] == $times['specifications'][$b->getTitle()]) {
                return 0;
            }
            if ($times['specifications'][$a->getTitle()] < $times['specifications'][$b->getTitle()]) {
                return -1;
            }
            return 1;
        });
    }

    public function setLoggerFile($log)
    {
        $this->log = $log;
    }

    private function loadTimes()
    {
        if (null === $this->log) {
            $this->log = sys_get_temp_dir() . '/phpspec.times.humbug.json';
        }
        if (!file_exists($this->log)) {
            throw new \Exception(sprintf(
                'Log file for collected times does not exist: %s',
                $this->log
            ));
        }
        return json_decode(file_get_contents($this->log), true);
    }
}