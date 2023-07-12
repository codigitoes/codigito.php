<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostRandom;

use Codigoce\Context\Shared\Domain\Query\Query;

class BlogpostRandomQuery implements Query
{
    private const DEFAULT_LIMIT = 3;

    public function __construct(
        public readonly int $limit = self::DEFAULT_LIMIT
    ) {
    }
}
