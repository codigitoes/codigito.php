<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Rabbitmq;

final class RabbitMqConnection
{
    private static ?\AMQPConnection $connection = null;
    private static ?\AMQPChannel    $channel    = null;
    /** @var \AMQPExchange[] */
    private static array $exchanges = [];
    /** @var \AMQPQueue[] */
    private static array $queues = [];

    public function __construct(private readonly array $configuration)
    {
    }

    public function queue(string $name): \AMQPQueue
    {
        if (!array_key_exists($name, self::$queues)) {
            $queue = new \AMQPQueue($this->channel());
            $queue->setName($name);

            self::$queues[$name] = $queue;
        }

        return self::$queues[$name];
    }

    public function exchange(string $name): \AMQPExchange
    {
        if (!array_key_exists($name, self::$exchanges)) {
            $exchange = new \AMQPExchange($this->channel());
            $exchange->setName($name);

            self::$exchanges[$name] = $exchange;
        }

        return self::$exchanges[$name];
    }

    private function channel(): \AMQPChannel
    {
        if (!self::$channel?->isConnected()) {
            self::$channel = new \AMQPChannel($this->connection());
        }

        return self::$channel;
    }

    private function connection(): \AMQPConnection
    {
        if (null === self::$connection) {
            self::$connection = new \AMQPConnection($this->configuration);
        }

        try {
            if (!self::$connection->isConnected()) {
                self::$connection->pconnect();
            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }

        return self::$connection;
    }
}
