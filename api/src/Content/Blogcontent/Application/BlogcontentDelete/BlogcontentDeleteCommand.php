<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentDelete;

use Codigito\Shared\Domain\Command\Command;

class BlogcontentDeleteCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId
    ) {
    }
}
