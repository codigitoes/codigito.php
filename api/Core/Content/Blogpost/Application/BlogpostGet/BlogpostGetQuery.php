<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Application\BlogpostGet;

use Core\\Shared\Domain\Query\Query;

class BlogpostGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
