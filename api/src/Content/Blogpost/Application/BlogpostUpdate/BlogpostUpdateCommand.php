<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostUpdate;

use Codigito\Shared\Domain\Command\Command;

class BlogpostUpdateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $base64image = null,
        public readonly ?string $tags = null
    ) {
    }
}
