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

use Humbug\PhpSpec\Listener\FreeMemoryListener;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class FreeMemoryExtension implements ExtensionInterface
{
    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->set('event_dispatcher.listeners.free_memory', function ($c) {
            return new FreeMemoryListener();
        });
    }
}
