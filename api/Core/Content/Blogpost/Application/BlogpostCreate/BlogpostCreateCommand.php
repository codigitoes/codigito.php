<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostCreate;

use Core\Shared\Domain\Command\Command;

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
