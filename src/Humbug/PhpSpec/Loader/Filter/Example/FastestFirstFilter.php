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

use PhpSpec\Loader\Node\ExampleNode;

class FastestFirstFilter extends AbstractFilter
{
    private $log;

    public function filter(array $array)
    {
        $times = $this->loadTimes();

        if (empty($array) || !isset($times['examples'][$this->getSpecificationTitle()])) {
            return $array;
        }
        $relevant = $times['examples'][$this->getSpecificationTitle()];

        @usort($array, function (ExampleNode $a, ExampleNode $b) use ($relevant) {
            $ua = 0;
            $ub = 0;
            foreach ($relevant as $entry) {
                if ($ua != 0 && $ub != 0) {
                    break;
                }
                if ($a->getTitle() == $entry['title']) {
                    $ua += $entry['time'];
                }
                if ($b->getTitle() == $entry['title']) {
                    $ub += $entry['time'];
                }
            }
            if ($ua == $ub) {
                return 0;
            }
            if ($ua < $ub) {
                return -1;
            }

            return 1;
        });

        return $array;
    }

    public function setLoggerFile($log)
    {
        $this->log = $log;
    }

    private function loadTimes()
    {
        if (null === $this->log) {
            $this->log = sys_get_temp_dir().'/phpspec.times.humbug.json';
        }
        if (!file_exists($this->log)) {
            throw new \Exception(sprintf(
                'Log file for collected times does not exist: %s. '
                .'Use the Humbug\PhpSpec\TimeCollectorExtension extension prior '
                .'to using the FastestFirstFilter filter at least once',
                $this->log
            ));
        }

        return json_decode(file_get_contents($this->log), true);
    }
}
