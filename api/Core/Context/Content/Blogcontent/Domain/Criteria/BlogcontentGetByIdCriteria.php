<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Page;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;

class BlogcontentGetByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $blogpostId,
        public readonly string $id
    ) {
        $filters = [
            $this->equal('blogpostId', $blogpostId),
            $this->equalId($id),
        ];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('position')),
            Page::one()
        );
    }
}
