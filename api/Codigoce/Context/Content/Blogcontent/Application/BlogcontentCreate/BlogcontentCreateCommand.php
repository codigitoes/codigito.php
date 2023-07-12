<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentCreate;

use Codigoce\Context\Shared\Domain\Command\Command;

class BlogcontentCreateCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId,
        public readonly ?string $html = null,
        public readonly ?string $base64image = null,
        public readonly ?string $youtube = null
    ) {
    }
}
