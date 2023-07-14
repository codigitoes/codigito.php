<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostGet;

use Core\Context\Shared\Domain\Query\Query;

class BlogpostGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
