<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Application\FortuneCreate;

use Codigito\Shared\Domain\Command\Command;

class FortuneCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {
    }
}
