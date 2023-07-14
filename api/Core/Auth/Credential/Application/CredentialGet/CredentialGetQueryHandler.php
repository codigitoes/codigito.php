<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Application\CredentialGet;

use Core\\Auth\Credential\Domain\Criteria\CredentialSearchByIdCriteria;
use Core\\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Core\\Auth\Credential\Domain\Repository\CredentialReader;
use Core\\Shared\Domain\Query\Query;
use Core\\Shared\Domain\Query\QueryHandler;

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
