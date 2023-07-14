<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Application\BlogcontentAll;

use Core\Context\Shared\Domain\Query\Query;

class BlogcontentAllQuery implements Query
{
    public function __construct(
        public readonly string $blogpostId
    ) {
    }
}
