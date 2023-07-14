<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Application\CredentialGet;

use Core\Context\Auth\Credential\Domain\Criteria\CredentialSearchByIdCriteria;
use Core\Context\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Core\Context\Auth\Credential\Domain\Repository\CredentialReader;
use Core\Context\Shared\Domain\Query\Query;
use Core\Context\Shared\Domain\Query\QueryHandler;

class CredentialGetQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CredentialReader $reader
    ) {
    }

    public function execute(Query $query): CredentialGetReadModel
    {
        $criteria = new CredentialSearchByIdCriteria($query->id);

        return $this->reader->getCredentialByCriteria($criteria);
    }
}
