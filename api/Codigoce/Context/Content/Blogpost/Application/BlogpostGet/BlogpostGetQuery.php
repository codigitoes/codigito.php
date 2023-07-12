<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogpost\Application\BlogpostGet;

use Codigoce\Context\Shared\Domain\Query\Query;

class BlogpostGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
