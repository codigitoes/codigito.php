<?php

declare(strict_types=1);

namespace Codigoce\Test\Shared\Fixture;

use Codigoce\Context\Auth\Credential\Domain\Criteria\CredentialSearchByEmailCriteria;
use Codigoce\Context\Auth\Credential\Domain\Model\Credential;
use Codigoce\Context\Auth\Credential\Domain\Repository\CredentialReader;
use Codigoce\Context\Auth\Credential\Domain\Repository\CredentialWriter;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialEmail;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialPassword;
use Codigoce\Context\Auth\Credential\Domain\ValueObject\CredentialRoles;
use Codigoce\Context\Auth\Credential\Infraestructure\Repository\CredentialReaderDoctrine;
use Codigoce\Context\Auth\Credential\Infraestructure\Repository\CredentialWriterDoctrine;
use Codigoce\Context\Shared\Domain\Helper\Codigoce;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        if (is_null($id)) {
            $id = CredentialId::random();
        }
        if (is_null($email)) {
            $email = new CredentialEmail(Codigoce::randomEmail());
        }
        if (is_null($password)) {
            $password = new CredentialPassword(Codigoce::randomString());
        }
        if (is_null($roles)) {
            $roles = CredentialRoles::user();
        }

        return $this->CredentialFromValuesForNew(
            $id,
            $email,
            $password,
            $roles
        );
    }
}
