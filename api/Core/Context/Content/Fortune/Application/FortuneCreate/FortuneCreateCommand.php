<?php

declare(strict_types=1);

namespace Core\Context\Content\Fortune\Application\FortuneCreate;

use Core\Context\Shared\Domain\Command\Command;

class FortuneCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {
    }
}
