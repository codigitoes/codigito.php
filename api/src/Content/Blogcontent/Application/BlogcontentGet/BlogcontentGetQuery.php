<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentGet;

use Codigito\Shared\Domain\Query\Query;

class BlogcontentGetQuery implements Query
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId
    ) {
    }
}
