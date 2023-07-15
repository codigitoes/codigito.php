<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Domain\ValueObject;

use Codigito\Auth\Credential\Domain\Exception\InvalidCredentialRolesException;

class CredentialRoles
{
    private const ROLE_USER  = 'ROLE_USER';
    private const ROLE_ADMIN = 'ROLE_ADMIN';
    private const ROLES      = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    final public static function admin(): static
    {
        return new CredentialRoles([self::ROLE_ADMIN]);
    }

    final public static function user(): static
    {
        return new CredentialRoles([self::ROLE_USER]);
    }

    public function __construct(public readonly array $value)
    {
        if (empty($this->value)) {
            $this->throwException($value);
        }
        foreach ($value as $role) {
            if (false === in_array($role, self::ROLES)) {
                $this->throwException($value);
            }
        }
    }

    protected function throwException(array $value): void
    {
        throw new InvalidCredentialRolesException(implode(',', $value));
    }
}
