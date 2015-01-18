<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Loader\Node\SpecificationNode;

class FreeMemoryListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'afterSpecification' => ['afterSpecification', -100]
        ];
    }

    public function afterSpecification(SpecificationEvent $event)
    {
        $this->safelyFreeProperties($event->getSpecification());
    }

    private function safelyFreeProperties(SpecificationNode $spec)
    {
        foreach ($this->getProperties($spec) as $property) {
            if ($this->isSafeToFreeProperty($property)) {
                $this->freeProperty($spec, $property);
            }
        }
    }

    private function getProperties(SpecificationNode $spec)
    {
        $reflection = new \ReflectionObject($spec);
        return $reflection->getProperties();
    }

    private function isSafeToFreeProperty(\ReflectionProperty $property)
    {
        return !$property->isStatic() && $this->isNotPhpSpecProperty($property);
    }

    private function isNotPhpSpecProperty(\ReflectionProperty $property)
    {
        return 0 !== strpos($property->getDeclaringClass()->getName(), 'PhpSpec\\') || $property->getName() == 'examples';
    }

    private function freeProperty(SpecificationNode $spec, \ReflectionProperty $property)
    {
        $property->setAccessible(true);
        $property->setValue($spec, null);
    }
}
