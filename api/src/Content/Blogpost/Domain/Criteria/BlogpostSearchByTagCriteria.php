<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\Filter;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\FilterTypeIn;
use Codigito\Shared\Domain\Filter\FilterTypeLike;
use Codigito\Shared\Domain\Filter\FilterTypeLikesOr;
use Codigito\Shared\Domain\Filter\FilterValue;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Page;

class BlogpostSearchByTagCriteria extends Criteria
{
    public function __construct(
        public readonly string $tag
    ) {
        $filters = [
            new Filter(
                new FilterField('tags'),
                new FilterTypeLike(),
                new FilterValue($tag)
            )
        ];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::all()
        );
    }
}
