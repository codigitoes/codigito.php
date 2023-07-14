<?php

declare(strict_types=1);

namespace Core\Content\Blogpost\Application\BlogpostSearch;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Query\Query;

class BlogpostSearchQuery implements Query
{
    public function __construct(
        public readonly ?string $pattern = '',
        public readonly ?int $page = Page::FIRST_PAGE,
        public readonly ?int $limit = Page::PAGE_LIMIT
    ) {
    }
}
