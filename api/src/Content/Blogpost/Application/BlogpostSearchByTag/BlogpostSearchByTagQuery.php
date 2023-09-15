<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostSearchByTag;

use Codigito\Shared\Domain\Query\Query;

class BlogpostSearchByTagQuery implements Query
{
    public function __construct(
        public readonly string $tag
    ) {
    }
}
