<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Domain\Repository;

use Core\Context\Auth\Credential\Domain\Model\Credential;
use Core\Context\Auth\Credential\Domain\Model\CredentialGetReadModel;
use Core\Context\Shared\Domain\Filter\Criteria;

interface CredentialReader
{
    public function getCredentialByCriteria(Criteria $criteria): CredentialGetReadModel;

    public function getCredentialModelByCriteria(Criteria $criteria): Credential;
}
