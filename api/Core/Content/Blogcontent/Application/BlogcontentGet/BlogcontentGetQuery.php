<?php

declare(strict_types=1);

namespace Core\Content\Blogcontent\Application\BlogcontentGet;

use Core\Shared\Domain\Query\Query;

class BlogcontentGetQuery implements Query
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId
    ) {
    }
}
