<?php

declare(strict_types=1);

namespace Codigoce\Test\Auth\Credential\End2End;

use Codigoce\Test\Auth\CodigoceAuthKernelTestCase;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;

class LoginActionTest extends CodigoceAuthKernelTestCase
{
    public const ENDPOINT = '/api/login_check';

    public function testItShouldResultATokenIfLoginAsNormalUser(): void
    {
        $email          = new CredentialEmail(Codigoce::randomEmail());
        $password       = new CredentialPassword(Codigoce::randomString());
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
