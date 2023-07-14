<?php

declare(strict_types=1);

namespace Core\Context\Auth\Credential\Domain\Repository;

use Core\Context\Auth\Credential\Domain\Model\Credential;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialId;

interface CredentialWriter
{
    public function create(Credential $credential): void;

    public function delete(CredentialId $id): void;

    public function update(Credential $credential): void;
}
