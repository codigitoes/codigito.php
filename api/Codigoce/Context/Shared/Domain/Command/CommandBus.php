<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}
