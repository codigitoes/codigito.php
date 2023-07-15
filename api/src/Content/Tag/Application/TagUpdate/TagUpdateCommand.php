<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagUpdate;

use Codigito\Shared\Domain\Command\Command;

class TagUpdateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $base64image = null
    ) {
    }
}
