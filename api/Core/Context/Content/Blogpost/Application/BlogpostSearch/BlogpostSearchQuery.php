<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Application\BlogpostSearch;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Query\Query;

class BlogpostSearchQuery implements Query
{
    public function __construct(
        public readonly ?string $pattern = '',
        public readonly ?int $page = Page::FIRST_PAGE,
        public readonly ?int $limit = Page::PAGE_LIMIT
    ) {
    }
}
