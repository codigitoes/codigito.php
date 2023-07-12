<?php

declare(strict_types=1);

namespace Codigoce\Test\Auth;

use Codigoce\Context\Auth\Credential\Domain\Model\Credential;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Shared\Fixture\TestApiClientFactory;
use Codigoce\Test\Shared\Fixture\TestAuthFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class CodigoceAuthKernelTestCase extends KernelTestCase
{
    use TestAuthFactory;
    use TestApiClientFactory;

    private ?array $admin = null;
    private ?array $user  = null;

    protected function getAdminCredential(): Credential
    {
        return $this->admin['credential'];
    }

    protected function getAdminEmail(): string
    {
        return $this->getAdminCredential()->email->value;
    }

    protected function getAdminPassword(): string
    {
        return $this->getAdminCredential()->password->value;
    }

    protected function getAdminToken(): string
    {
        return $this->admin['token'];
    }

    protected function getUserCredential(): Credential
    {
        return $this->user['credential'];
    }

    protected function getUserToken(): string
    {
        return $this->user['token'];
    }

    protected function setUp(): void
    {
        $adminCredential = $this->CredentialPersisted(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            new CredentialEmail(Codigoce::randomEmail()),
            new CredentialPassword(Codigoce::randomString()),
            CredentialRoles::admin()
        );
        $this->admin = [
            'credential' => $adminCredential,
            'token'      => $this->login($adminCredential->email->value, $adminCredential->password->value),
        ];

        $userCredential = $this->CredentialPersisted(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            new CredentialEmail(Codigoce::randomEmail()),
            new CredentialPassword(Codigoce::randomString()),
            CredentialRoles::user()
        );
        $this->user = [
            'credential' => $userCredential,
            'token'      => $this->login($userCredential->email->value, $userCredential->password->value),
        ];
    }

    protected function tearDown(): void
    {
        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $this->admin['credential']->id
        );
        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $this->user['credential']->id
        );
    }

    protected function getManager(): EntityManager
    {
        return static::getContainer()->get('doctrine.orm.default_entity_manager');
    }

    protected function getRegistry(): ManagerRegistry
    {
        return static::getContainer()->get('Doctrine\Persistence\ManagerRegistry');
    }

    protected function getHasher(): UserPasswordHasherInterface
    {
        return static::getContainer()->get('Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface');
    }
}
