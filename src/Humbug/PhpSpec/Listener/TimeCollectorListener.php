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

use Humbug\PhpSpec\Logger\JsonLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;

class TimeCollectorListener implements EventSubscriberInterface
{

    public function __construct(JsonLogger $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'afterSpecification' => ['afterSpecification', -10],
            'afterExample' => ['afterExample', -10],
            'afterSuite' => ['afterSuite', -10]
        ];
    }

    public function afterExample(ExampleEvent $event)
    {
        $this->logger->logExample(
            $this->getSpecification()->getTitle(),
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
