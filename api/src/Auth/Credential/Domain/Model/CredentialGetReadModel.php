<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;

class CredentialGetReadModel implements ReadModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly array $roles,
        public readonly string $created,
        public readonly string $updated
    ) {
    }

    public function toPrimitives(): array
    {
        return [
            'id'      => $this->id,
            'email'   => $this->email,
            'roles'   => $this->roles,
            'created' => $this->created,
            'updated' => $this->updated,
        ];
    }
}
