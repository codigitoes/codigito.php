<?php

declare(strict_types=1);

namespace Core\Test\Shared\Fixture;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Core\Context\Shared\Domain\Helper\Codigito;
use Core\Context\Auth\Credential\Domain\Model\Credential;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Core\Context\Auth\Credential\Domain\Repository\CredentialReader;
use Core\Context\Auth\Credential\Domain\Repository\CredentialWriter;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Core\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Core\Context\Auth\Credential\Domain\Criteria\CredentialSearchByEmailCriteria;
use Core\Context\Auth\Credential\Infraestructure\Repository\CredentialReaderDoctrine;
use Core\Context\Auth\Credential\Infraestructure\Repository\CredentialWriterDoctrine;

trait TestAuthFactory
{
    final protected function CredentialDelete(
        EntityManagerInterface $manager,
        ManagerRegistry $registry,
        UserPasswordHasherInterface $hasher,
        CredentialId $id
    ): void {
        $this->CredentialWriter(
            $manager,
            $registry,
            $hasher
        )->delete($id);
    }

    protected function CredentialPersisted(
        EntityManagerInterface $manager,
        ManagerRegistry $registry,
        UserPasswordHasherInterface $hasher,
        ?CredentialEmail $email = null,
        ?CredentialPassword $password = null,
        ?CredentialRoles $roles = null
    ): Credential {
        $credential = $this->RandomCredentialForNew(null, $email, $password, $roles);

        $this->CredentialWriter(
            $manager,
            $registry,
            $hasher
        )->create($credential);

        return $credential;
    }

    final protected function CredentialWriter(
        EntityManagerInterface $manager,
        ManagerRegistry $registry,
        UserPasswordHasherInterface $hasher
    ): CredentialWriter {
        return new CredentialWriterDoctrine($manager, $registry, $hasher);
    }

    final protected function CredentialReader(EntityManagerInterface $manager): CredentialReader
    {
        return new CredentialReaderDoctrine($manager);
    }

    final protected function CredentialGetModelByEmail(string $email): Credential
    {
        $criteria = new CredentialSearchByEmailCriteria($email);

        return $this->CredentialReader($this->getManager())->getCredentialModelByCriteria($criteria);
    }

    final protected function CredentialFromValuesForNew(
        CredentialId $id,
        CredentialEmail $email,
        CredentialPassword $password,
        CredentialRoles $roles
    ): Credential {
        return Credential::createNew(
            $id,
            $email,
            $password,
            $roles
        );
    }

    final protected function RandomCredentialForNew(
        ?CredentialId $id = null,
        ?CredentialEmail $email = null,
        ?CredentialPassword $password = null,
        ?CredentialRoles $roles = null
    ): Credential {
        is_object($id) ? $id : $id                   = CredentialId::random();
        is_object($email) ? $email : $email          = new CredentialEmail(Codigito::randomEmail());
        is_object($password) ? $password : $password = new CredentialPassword(Codigito::randomString());
        is_object($roles) ? $roles : $roles          = CredentialRoles::user();

        return $this->CredentialFromValuesForNew(
            $id,
            $email,
            $password,
            $roles
        );
    }
}
