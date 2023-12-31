<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagCreate;

use Codigito\Shared\Domain\Command\Command;

class TagCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $base64image
    ) {
    }
}
