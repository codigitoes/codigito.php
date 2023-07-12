<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;

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
