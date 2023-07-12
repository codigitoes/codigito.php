<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentUpdate;

use Codigoce\Context\Shared\Domain\Command\Command;

class BlogcontentUpdateCommand implements Command
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
