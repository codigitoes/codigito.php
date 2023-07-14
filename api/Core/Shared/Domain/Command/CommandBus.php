<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}
