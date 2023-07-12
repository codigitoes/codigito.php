<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagCreate;

use Codigoce\Context\Shared\Domain\Command\Command;

class TagCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $base64image
    ) {
    }
}
