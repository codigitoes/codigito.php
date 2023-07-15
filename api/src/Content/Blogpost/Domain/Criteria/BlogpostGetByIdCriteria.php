<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Page;

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
