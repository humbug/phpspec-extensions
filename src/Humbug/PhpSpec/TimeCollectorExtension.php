<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec;

use Humbug\PhpSpec\Listener\TimeCollectorListener;
use Humbug\PhpSpec\Logger\JsonTimeLogger;
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
                new JsonTimeLogger($c->getParam('humbug.time_collector.target'))
            );
        });
    }
}
