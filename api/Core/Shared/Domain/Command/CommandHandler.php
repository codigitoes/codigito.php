<?php

declare(strict_types=1);

namespace Core\\Shared\Domain\Command;

interface CommandHandler
{
    public function execute(Command $command): void;
}
