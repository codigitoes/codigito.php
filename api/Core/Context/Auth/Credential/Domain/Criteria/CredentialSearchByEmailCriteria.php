<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Domain\Criteria;

use Core\Context\Shared\Domain\Filter\Criteria;
use Core\Context\Shared\Domain\Filter\FilterField;
use Core\Context\Shared\Domain\Filter\Filters;
use Core\Context\Shared\Domain\Filter\Order;
use Core\Context\Shared\Domain\Filter\Page;

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
