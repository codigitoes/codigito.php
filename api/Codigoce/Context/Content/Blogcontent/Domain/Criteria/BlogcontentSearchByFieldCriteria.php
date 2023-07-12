<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\Filter;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\FilterTypeEqual;
use Codigoce\Context\Shared\Domain\Filter\FilterValue;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Page;

class BlogcontentSearchByFieldCriteria extends Criteria
{
    public function __construct(
        public readonly string $blogpostId,
        public readonly string $field,
        public readonly string|int|bool|null $value,
        int $page = Page::FIRST_PAGE,
        int $limit = Page::PAGE_LIMIT
    ) {
        $filters = [
            $this->equal('blogpostId', $blogpostId),
            new Filter(
                new FilterField($this->field),
                new FilterTypeEqual(),
                new FilterValue($this->value)
            )];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('position')),
            Page::from($page, $limit)
        );
    }
}
