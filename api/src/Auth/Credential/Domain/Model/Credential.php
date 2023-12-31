<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\Model;

use Codigito\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Shared\Domain\Model\DomainModel;

class Credential implements DomainModel
{
    private function __construct(
        public readonly CredentialId $id,
        public readonly CredentialEmail $email,
        public readonly CredentialPassword $password,
        public readonly CredentialRoles $roles,
        public readonly \DateTimeInterface $created,
        public readonly \DateTimeInterface $updated
    ) {
    }

    final public static function createNew(
        CredentialId $id,
        CredentialEmail $email,
        CredentialPassword $password,
        CredentialRoles $roles
    ) {
        $result = new static(
            $id,
            $email,
            $password,
            $roles,
            new \DateTime(),
            new \DateTime()
        );

        return $result;
    }

    final public static function read(
        CredentialId $id,
        CredentialEmail $email,
        CredentialPassword $password,
        CredentialRoles $roles,
        \DateTimeInterface $created,
        \DateTimeInterface $updated
    ) {
        return new static(
            $id,
            $email,
            $password,
            $roles,
            $created,
            $updated
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id'       => $this->id->value,
            'email'    => $this->email->value,
            'password' => $this->password->value,
            'roles'    => $this->roles->value,
            'created'  => Codigito::datetimeToHuman($this->created),
            'updated'  => Codigito::datetimeToHuman($this->updated),
        ];
    }
}
