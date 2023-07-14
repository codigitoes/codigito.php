<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Application\MailingSearch;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Query\Query;

class MailingSearchQuery implements Query
{
    public function __construct(
        public readonly ?string $pattern = '',
        public readonly ?int $page = Page::FIRST_PAGE,
        public readonly ?int $limit = Page::PAGE_LIMIT
    ) {
    }
}
