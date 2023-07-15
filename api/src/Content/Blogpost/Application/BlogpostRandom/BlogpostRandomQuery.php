<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostRandom;

use Codigito\Shared\Domain\Query\Query;

class BlogpostRandomQuery implements Query
{
    private const DEFAULT_LIMIT = 3;

    public function __construct(
        public readonly int $limit = self::DEFAULT_LIMIT
    ) {
    }
}
