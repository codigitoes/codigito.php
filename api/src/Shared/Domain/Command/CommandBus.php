<?php

declare(strict_types=1);

namespace Codigito\Shared\Domain\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}
