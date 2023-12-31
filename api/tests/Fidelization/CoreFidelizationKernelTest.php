<?php

declare(strict_types=1);

namespace Codigito\Tests\Fidelization;

use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Codigito\Tests\Shared\Fixture\TestAuthFactory;
use Codigito\Shared\Domain\Helper\Codigito;
use Codigito\Tests\Shared\Infraestructure\ApiClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Codigito\Tests\Shared\Fixture\TestFidelizationFactory;
use Codigito\Fidelization\Mailing\Domain\Model\Mailing;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialPassword;

abstract class CoreFidelizationKernelTest extends KernelTestCase
{
    use TestFidelizationFactory;
    use TestAuthFactory;

    private ?Mailing $mailing = null;
    private ?array $admin     = null;
    protected ?ApiClient $api = null;

    public function __construct()
    {
        parent::__construct();

        $this->api = new ApiClient();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailing   = $this->MailingPersisted($this->getManager());
        $adminCredential = $this->CredentialPersisted(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            new CredentialEmail(Codigito::randomEmail()),
            new CredentialPassword(Codigito::randomString()),
            CredentialRoles::admin()
        );
        $this->admin = [
            'credential' => $adminCredential,
            'token'      => $this->api->login($adminCredential->email->value, $adminCredential->password->value),
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
