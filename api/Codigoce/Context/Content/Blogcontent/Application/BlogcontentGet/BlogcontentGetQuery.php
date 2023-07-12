<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentGet;

use Codigoce\Context\Shared\Domain\Query\Query;

class BlogcontentGetQuery implements Query
{
    public function __construct(
        public readonly string $id,
        public readonly string $blogpostId
    ) {
    }
}
