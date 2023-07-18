<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Rabbitmq;

use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Shared\Domain\Event\DomainEventSubscriber;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\last;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventSubscriber $subscriber): string
    {
        $subscriberClassPaths = explode('\\', str_replace('Codigito', 'codigito', $subscriber::class));

        $queueNameParts = [
            $subscriberClassPaths[0],
            $subscriberClassPaths[1],
            $subscriberClassPaths[2],
            last($subscriberClassPaths),
        ];

        return implode('.', map(self::toSnakeCase(), $queueNameParts));
    }

    public static function formatRetry(DomainEventSubscriber $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    public static function formatDeadLetter(DomainEventSubscriber $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }

    public static function shortFormat(DomainEventSubscriber $subscriber): string
    {
        $subscriberCamelCaseName = (string) last(explode('\\', $subscriber::class));

        return Codigito::toSnakeCase($subscriberCamelCaseName);
    }

    private static function toSnakeCase(): callable
    {
        return static fn (string $text) => Codigito::toSnakeCase($text);
    }
}
