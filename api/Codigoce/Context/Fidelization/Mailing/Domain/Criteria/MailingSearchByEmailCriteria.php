<?php

declare(strict_types=1);

namespace Codigoce\Context\Fidelization\Mailing\Domain\Criteria;

use Codigoce\Context\Shared\Domain\Filter\Page;
use Codigoce\Context\Shared\Domain\Filter\Order;
use Codigoce\Context\Shared\Domain\Filter\Filter;
use Codigoce\Context\Shared\Domain\Filter\Filters;
use Codigoce\Context\Shared\Domain\Filter\Criteria;
use Codigoce\Context\Shared\Domain\Filter\FilterField;
use Codigoce\Context\Shared\Domain\Filter\FilterValue;
use Codigoce\Context\Shared\Domain\Filter\FilterTypeEqual;

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
