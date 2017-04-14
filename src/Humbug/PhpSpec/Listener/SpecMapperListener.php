<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\PhpSpec\Listener;

use Humbug\PhpSpec\Logger\JsonSpecMapLogger;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\SuiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SpecMapperListener implements EventSubscriberInterface
{
    public function __construct(JsonSpecMapLogger $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'afterSpecification' => ['afterSpecification', -10],
            'afterSuite'         => ['afterSuite', -10],
        ];
    }

    public function afterSpecification(SpecificationEvent $event)
    {
        $node = $event->getSpecification();
        $resource = $node->getResource();
        $this->logger->logSpecification(
            $resource->getSrcFilename(),
            $node->getTitle(),
            $node->getClassReflection()->name,
            $resource->getSrcClassname()
        );
    }

    public function afterSuite(SuiteEvent $event)
    {
        $this->logger->write();
    }
}
