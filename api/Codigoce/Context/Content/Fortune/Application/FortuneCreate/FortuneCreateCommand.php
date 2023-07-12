<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Application\FortuneCreate;

use Codigoce\Context\Shared\Domain\Command\Command;

class FortuneCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {
    }
}
