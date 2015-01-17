<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec;

use Humbug\PhpSpec\Listener\TimeCollectorListener;
use Humbug\PhpSpec\Logger\JsonLogger;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class TimeCollectorExtension implements ExtensionInterface
{

    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->set('event_dispatcher.listeners.time_collector', function ($c) {
            return new TimeCollectorListener(
                new JsonLogger
            );
        });
    }
}