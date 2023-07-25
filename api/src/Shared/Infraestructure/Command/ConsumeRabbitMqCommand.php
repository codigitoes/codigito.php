<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Command;

use Codigito\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Codigito\Shared\Infraestructure\Rabbitmq\RabbitMqConnection;

final class ConsumeRabbitMqCommand extends Command
{
    private const QUEUES = ['codigito.fidelization.mailing.mailing_send_confirmation_on_mailing_created', 'codigito.fidelization.mailing.mailing_send_welcome_on_mailing_confirmed'];

    public function __construct(private readonly RabbitMqConnection $connection, private readonly \Traversable $subscribers)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('ce:domain-events:rabbitmq:consume')->setDescription('Consume the RabbitMQ domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (self::QUEUES as $queueName) {
            $queue = $this->connection->queue($queueName);

            $output->writeln('');
            $output->writeln('{.".}> consume iniciado');
            $output->writeln('{.".}> QUEUE: '.$queueName);

            try {
                $queue->consume(function ($envelope, $queue) use ($output): void {
                    $output->writeln('');
                    $body      = json_decode($envelope->getBody());
                    $eventName = $body->data->type;
                    $output->writeln('{.".}>>>> consumiendo mensaje recibido para el evento: '.$eventName);
                    $output->writeln('{.".}>>>> buscando subscriber....');
                    foreach ($this->subscribers as $aSubscriber) {
                        if (in_array($eventName, $aSubscriber->subscribedTo())) {
                            $event = DomainEvent::fromPrimitives($body->data->type, (array) $body->data->attributes->body);
                            $output->writeln('{.".}>>>> subscriber encontrado, ejecutando service con event(JSON): '.json_encode($event));
                            $aSubscriber->handlerEvent($event);
                            $queue->ack($envelope->getDeliveryTag());
                            $output->writeln('{.".}>>>> mensaje recibido consumido ok');
                        }
                    }
                });
            } catch (\Throwable) {
            }

            $output->writeln('{.".}> consume de cola completado :)');
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}
