<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Event;

use Codigito\Shared\Domain\Event\DomainEventBus;
use Codigito\Shared\Domain\Event\DomainEventsCollection;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

class DomainEventStaticBus implements DomainEventBus
{
    private array $eventsWithSubscribers = [];

    public function __construct(iterable $subscribers)
    {
        $this->register($subscribers);
    }

    public function publish(DomainEventsCollection $events): void
    {
        foreach ($events->all() as $anEvent) {
            $subscribers = [];
            if (isset($this->eventsWithSubscribers[$anEvent->name->value])) {
                $subscribers = $this->eventsWithSubscribers[$anEvent->name->value];
            }
            foreach ($subscribers as $aSubscriber) {
                $aSubscriber->handlerEvent($anEvent);
            }
        }
    }

    private function register(iterable $subscribers): void
    {
        foreach ($subscribers as $aSubscriber) {
            if (false === $aSubscriber instanceof DomainEventSubscriber) {
                continue;
            }

            foreach ($aSubscriber->subscribedTo() as $anEventName) {
                $subscribersRegisteredPerEvent = [];
                if (isset($this->eventsWithSubscribers[$anEventName])) {
                    $subscribersRegisteredPerEvent[] = $this->eventsWithSubscribers[$anEventName];
                }
                $subscribersRegisteredPerEvent[] = $aSubscriber;

                $this->eventsWithSubscribers[$anEventName] = $subscribersRegisteredPerEvent;
            }
        }
    }
}
