<?php

declare(strict_types=1);

namespace Core\Fidelization\Mailing\Domain\Criteria;

use Core\Shared\Domain\Filter\Page;
use Core\Shared\Domain\Filter\Order;
use Core\Shared\Domain\Filter\Filter;
use Core\Shared\Domain\Filter\Filters;
use Core\Shared\Domain\Filter\Criteria;
use Core\Shared\Domain\Filter\FilterField;
use Core\Shared\Domain\Filter\FilterValue;
use Core\Shared\Domain\Filter\FilterTypeEqual;

class MailingSearchByEmailCriteria extends Criteria
{
    public function __construct(
        public readonly string $email
    ) {
        $filters = [new Filter(
            new FilterField('email'),
            new FilterTypeEqual(),
            new FilterValue($email)
        )];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
