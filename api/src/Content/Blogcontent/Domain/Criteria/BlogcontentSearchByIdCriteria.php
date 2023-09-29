<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Page;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Filter;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\FilterValue;
use Codigito\Shared\Domain\Filter\FilterTypeEqual;

class BlogcontentSearchByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $blogpostId,
        public readonly string $id,
        string $fieldName = null
    ) {
        $idKey = 'id';
        if ($fieldName) {
            $idKey = $fieldName;
        }

        $filters = [
            $this->equal('blogpostId', $blogpostId),
            new Filter(
                new FilterField($idKey),
                new FilterTypeEqual(),
                new FilterValue($id)
            ),
        ];

        parent::__construct(
            new Filters($filters),
            Order::asc(new FilterField('position')),
            Page::first25()
        );
    }
}
