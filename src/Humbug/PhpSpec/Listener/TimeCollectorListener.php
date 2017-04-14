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

use Humbug\PhpSpec\Logger\JsonTimeLogger;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\SuiteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TimeCollectorListener implements EventSubscriberInterface
{
    public function __construct(JsonTimeLogger $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'afterSpecification' => ['afterSpecification', -10],
            'afterExample'       => ['afterExample', -10],
            'afterSuite'         => ['afterSuite', -10],
        ];
    }

    public function afterExample(ExampleEvent $event)
    {
        $this->logger->logExample(
            $event->getSpecification()->getTitle(),
            $event->getTitle(),
            $event->getTime()
        );
    }

    public function afterSpecification(SpecificationEvent $event)
    {
        $this->logger->logSpecification(
            $event->getTitle(),
            $event->getTime()
        );
    }

    public function afterSuite(SuiteEvent $event)
    {
        $this->logger->write();
    }
}
