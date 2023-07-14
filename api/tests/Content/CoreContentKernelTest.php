<?php

declare(strict_types=1);

namespace App\Tests\Content;

use Core\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Core\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Core\Content\Blogpost\Domain\Model\Blogpost;
use Core\Content\Blogcontent\Domain\Model\Blogcontent;
use Core\Content\Tag\Domain\Model\Tag;
use Core\Shared\Domain\Helper\Codigito;
use App\Tests\Shared\Fixture\TestApiClientFactory;
use App\Tests\Shared\Fixture\TestAuthFactory;
use App\Tests\Shared\Fixture\TestContentBlogcontentFactory;
use App\Tests\Shared\Fixture\TestContentBlogpostFactory;
use App\Tests\Shared\Fixture\TestContentTagFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Core\Content\Fortune\Domain\Model\Fortune;
use App\Tests\Shared\Fixture\TestContentFortuneFactory;

abstract class CoreContentKernelTest extends KernelTestCase
{
    use TestContentTagFactory;
    use TestContentBlogpostFactory;
    use TestContentBlogcontentFactory;
    use TestContentFortuneFactory;
    use TestAuthFactory;
    use TestApiClientFactory;

    private ?Fortune $fortune         = null;
    private ?Blogcontent $blogcontent = null;
    private ?Blogpost $blogpost       = null;
    private ?Tag $tag                 = null;
    private ?array $admin             = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fortune     = $this->FortunePersisted($this->getManager());
        $this->tag         = $this->TagPersisted($this->getManager());
        $this->blogpost    = $this->BlogpostPersisted($this->getManager());
        $this->blogcontent = $this->BlogcontentPersisted($this->getManager());
        $adminCredential   = $this->CredentialPersisted(
            $this->getManager(),
            $this->getRegistry(),
            $this->getHasher(),
            new CredentialEmail(Codigito::randomEmail()),
            new CredentialPassword(Codigito::randomString()),
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

        $this->FortuneDelete($this->getManager(), $this->fortune);
        $this->BlogcontentDelete($this->getManager(), $this->blogcontent);
        $this->BlogpostDelete($this->getManager(), $this->blogpost);
        $this->TagDelete($this->getManager(), $this->tag);
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
