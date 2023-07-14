<?php

declare(strict_types=1);

namespace Core\Shared\Infraestructure\Command;

use Core\Shared\Domain\Command\Command;
use Core\Shared\Domain\Command\CommandBus;
use Core\Shared\Domain\Exception\InvalidCommandCantFindHandlerException;

class CommandStaticBus implements CommandBus
{
    private array $handlers = [];

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $aHandler) {
            $name                  = str_replace('Handler', '', get_class($aHandler));
            $this->handlers[$name] = $aHandler;
        }
    }

    public function execute(Command $command): void
    {
        $shortClassName = (new \ReflectionClass($command))->getName();
        if (isset($this->handlers[$shortClassName])) {
            $this->handlers[$shortClassName]->execute($command);

            return;
        }

        throw new InvalidCommandCantFindHandlerException($shortClassName);
    }
}
