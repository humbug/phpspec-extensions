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

use Humbug\PhpSpec\Logger\JsonSpecMapLogger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\Event\ExampleEvent;
use PhpSpec\Event\SpecificationEvent;
use PhpSpec\Event\SuiteEvent;

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
        ];
    }

    public function afterSpecification(SpecificationEvent $event)
    {
        $this->logger->logSpecification(
            $event->getClass()->getFile(),
            $event->getTitle(),
            $event->getClass()->name,
        );
    }

    public function afterSuite(SuiteEvent $event)
    {
        $this->logger->write();
    }
}
