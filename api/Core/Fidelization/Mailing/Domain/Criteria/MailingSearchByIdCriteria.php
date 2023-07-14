<?php

declare(strict_types=1);

namespace Core\\Fidelization\Mailing\Domain\Criteria;

use Core\\Shared\Domain\Filter\Page;
use Core\\Shared\Domain\Filter\Order;
use Core\\Shared\Domain\Filter\Filter;
use Core\\Shared\Domain\Filter\Filters;
use Core\\Shared\Domain\Filter\Criteria;
use Core\\Shared\Domain\Filter\FilterField;
use Core\\Shared\Domain\Filter\FilterValue;
use Core\\Shared\Domain\Filter\FilterTypeEqual;

class MailingSearchByIdCriteria extends Criteria
{
    public function __construct(
        public readonly string $id,
        ?string $fieldEmail = null
    ) {
        $idKey = 'id';
        if ($fieldEmail) {
            $idKey = $fieldEmail;
        }

        $filters = [new Filter(
            new FilterField($idKey),
            new FilterTypeEqual(),
            new FilterValue($id)
        )];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
