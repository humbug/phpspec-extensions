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

use Humbug\PhpSpec\Listener\SpecMapperListener;
use Humbug\PhpSpec\Logger\JsonSpecMapLogger;
use PhpSpec\Extension\ExtensionInterface;
use PhpSpec\ServiceContainer;

class SpecMapperExtension implements ExtensionInterface
{

    /**
     * @param ServiceContainer $container
     */
    public function load(ServiceContainer $container)
    {
        $container->set('event_dispatcher.listeners.spec_mapper', function ($c) {
            return new SpecMapperListener(
                new JsonSpecMapLogger($c->getParam('humbug.spec_mapper.target'))
            );
        });
    }
}