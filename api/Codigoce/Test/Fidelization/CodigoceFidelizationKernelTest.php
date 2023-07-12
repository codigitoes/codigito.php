<?php

declare(strict_types=1);

namespace Codigoce\Test\Fidelization;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Codigoce\Test\Shared\Fixture\TestAuthFactory;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Codigoce\Test\Shared\Fixture\TestApiClientFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Codigoce\Test\Shared\Fixture\TestFidelizationFactory;
use Codigoce\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;

abstract class CodigoceFidelizationKernelTest extends KernelTestCase
{
    use TestFidelizationFactory;
    use TestAuthFactory;
    use TestApiClientFactory;

    private ?Mailing $mailing = null;
    private ?array $admin     = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailing   = $this->MailingPersisted($this->getManager());
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
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->MailingDelete($this->getManager(), $this->mailing);
        $this->CredentialDelete(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            $this->admin['credential']->id
        );
    }

    final protected function getAdminToken(): string
    {
        return $this->admin['token'];
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
