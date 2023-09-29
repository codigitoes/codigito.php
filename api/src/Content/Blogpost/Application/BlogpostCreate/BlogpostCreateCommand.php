<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostCreate;

use Codigito\Shared\Domain\Command\Command;

class BlogpostCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $base64image,
        public readonly string $youtube,
        public readonly string $tags,
        public readonly ?string $html = null,
    ) {
    }
}
