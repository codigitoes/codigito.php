<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Application\BlogcontentSearch;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Query\Query;

class BlogcontentSearchQuery implements Query
{
    public function __construct(
        public readonly string $blogpostId,
        public readonly ?string $pattern = '',
        public readonly ?int $page = Page::FIRST_PAGE,
        public readonly ?int $limit = Page::PAGE_LIMIT
    ) {
    }
}
