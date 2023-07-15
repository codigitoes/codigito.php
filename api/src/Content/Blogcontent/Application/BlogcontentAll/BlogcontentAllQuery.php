<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentAll;

use Codigito\Shared\Domain\Query\Query;

class BlogcontentAllQuery implements Query
{
    public function __construct(
        public readonly string $blogpostId
    ) {
    }
}
