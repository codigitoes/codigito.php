<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostCreate;

use Codigoce\Context\Shared\Domain\Command\Command;

class BlogpostCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $base64image,
        public readonly string $tags
    ) {
    }
}
