<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\Criteria;

use Codigito\Shared\Domain\Filter\Criteria;
use Codigito\Shared\Domain\Filter\FilterField;
use Codigito\Shared\Domain\Filter\Filters;
use Codigito\Shared\Domain\Filter\Order;
use Codigito\Shared\Domain\Filter\Page;

class CredentialSearchByEmailCriteria extends Criteria
{
    public function __construct(
        public readonly string $email
    ) {
        $filters = [$this->equal('email', $email)];

        parent::__construct(
            new Filters($filters),
            Order::desc(new FilterField('created')),
            Page::first25()
        );
    }
}
