<?php

declare(strict_types=1);

namespace Codigito\Tests\Auth\Credential\End2End;

use Codigito\Tests\Auth\CoreAuthKernelTestCase;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialPassword;

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

        $token = $this->api->login($userCredential->email->value, $userCredential->password->value);
        self::assertIsString($token);

        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $userCredential->id
        );
    }
}
