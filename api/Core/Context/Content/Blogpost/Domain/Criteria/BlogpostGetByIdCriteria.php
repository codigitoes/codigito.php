<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogpost\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Page;

class BlogpostGetByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id
    ) {
        $filters = [$this->equalId($id)];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
