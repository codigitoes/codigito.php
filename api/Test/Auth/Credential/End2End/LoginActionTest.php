<?php

declare(strict_types=1);

namespace Core\Test\Auth\Credential\End2End;

use Core\Test\Auth\CoreAuthKernelTestCase;
use Core\\Shared\Domain\Helper\Codigito;
use Core\\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\\Auth\Credential\Domain\ValueObject\CredentialPassword;

class LoginActionTest extends CoreAuthKernelTestCase
{
    public const ENDPOINT = '/api/login_check';

    public function testItShouldResultATokenIfLoginAsNormalUser(): void
    {
        $email          = new CredentialEmail(Codigito::randomEmail());
        $password       = new CredentialPassword(Codigito::randomString());
        $userCredential = $this->CredentialPersisted(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $email,
            $password,
            CredentialRoles::user()
        );

        $token = $this->login($userCredential->email->value, $userCredential->password->value);
        self::assertIsString($token);

        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $userCredential->id
        );
    }
}
