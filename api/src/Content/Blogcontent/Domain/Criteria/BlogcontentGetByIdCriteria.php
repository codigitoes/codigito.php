<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;

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
