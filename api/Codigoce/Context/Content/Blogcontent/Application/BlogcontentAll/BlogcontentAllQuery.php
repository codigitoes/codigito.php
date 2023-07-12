<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Application\BlogcontentAll;

use Codigoce\Context\Shared\Domain\Query\Query;

class BlogcontentAllQuery implements Query
{
    public function __construct(
        public readonly string $blogpostId
    ) {
    }
}
