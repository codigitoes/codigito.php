<?php

declare(strict_types=1);

namespace Core\\Auth\Credential\Domain\Repository;

use Core\\Auth\Credential\Domain\Model\Credential;
use Core\\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Core\\Shared\Domain\Filter\Criteria;

interface CredentialReader
{
    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel;

    public function getCredentialModelByCriteria(Criteria $criteria): Credential;
}
