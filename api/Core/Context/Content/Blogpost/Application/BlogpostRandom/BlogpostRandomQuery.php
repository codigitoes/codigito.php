<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostRandom;

use Core\Context\Shared\Domain\Query\Query;

class BlogpostRandomQuery implements Query
{
    private const DEFAULT_LIMIT = 3;

    public function __construct(
        public readonly int $limit = self::DEFAULT_LIMIT
    ) {
    }
}
