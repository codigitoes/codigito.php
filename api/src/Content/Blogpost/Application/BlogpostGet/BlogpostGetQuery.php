<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostGet;

use Codigito\Shared\Domain\Query\Query;

class BlogpostGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
