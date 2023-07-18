<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Rabbitmq;

use Codigito\Shared\Domain\Event\DomainEvent;
use Codigito\Shared\Domain\Event\DomainEventBus;
use Codigito\Shared\Domain\Event\DomainEventsCollection;

use function Lambdish\Phunctional\each;

final class RabbitMqEventBus implements DomainEventBus
{
    private $connection;
    private $exchangeName;
    private $failoverPublisher;

    public function __construct(
        RabbitMqConnection $connection,
        string $exchangeName
    ) {
        $this->connection   = $connection;
        $this->exchangeName = $exchangeName;
    }

    public function publish(DomainEventsCollection $events): void
    {
        each($this->publisher(), $events->all());
    }

    private function publisher(): callable
    {
        return function (DomainEvent $event) {
            try {
                $this->publishEvent($event);
            } catch (\AMQPException $error) {
                $this->failoverPublisher->publish($event);
            }
        };
    }

    private function publishEvent(DomainEvent $event): void
    {
        $body       = $this->serialize($event);
        $routingKey = $event->name->value;
        $messageId  = $event->id->value;

        $this->connection->exchange($this->exchangeName)->publish(
            $body,
            $routingKey,
            AMQP_NOPARAM,
            [
                'message_id'       => $messageId,
                'content_type'     => 'application/json',
                'content_encoding' => 'utf-8',
            ]
        );
    }

    private function serialize(DomainEvent $domainEvent): string
    {
        return json_encode(
            [
                'data' => [
                    'id'          => $domainEvent->id->value,
                    'type'        => $domainEvent->name->value,
                    'occurred_on' => $domainEvent->ocurredOn,
                    'attributes'  => array_merge($domainEvent->toPrimitives(), ['id' => $domainEvent->id->value]),
                ],
                'meta' => [],
            ]
        );
    }
}
