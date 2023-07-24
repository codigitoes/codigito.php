<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Codigito\Shared\Infraestructure\Rabbitmq\RabbitMqConfigurer;

final class ConfigureRabbitMqCommand extends Command
{
    private $configurer;
    private $exchangeName;
    private $subscribers;

    public function __construct(RabbitMqConfigurer $configurer, string $exchangeName, \Traversable $subscribers)
    {
        parent::__construct();

        $this->configurer   = $configurer;
        $this->exchangeName = $exchangeName;
        $this->subscribers  = $subscribers;
    }

    protected function configure(): void
    {
        $this->setName('ce:domain-events:rabbitmq:configure')->setDescription('Configure the RabbitMQ to allow publish & consume domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configurer->configure($this->exchangeName, ...iterator_to_array($this->subscribers));

        $output->writeln('');
        $output->writeln('{.".}> configuracion completada :)');
        $output->writeln('');

        return Command::SUCCESS;
    }
}
