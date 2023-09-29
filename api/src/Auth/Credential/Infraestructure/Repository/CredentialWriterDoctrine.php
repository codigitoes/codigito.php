<?php

declare(strict_types=1);

namespace Codigito\Auth\Credential\Infraestructure\Repository;

use Codigito\Auth\Credential\Domain\Model\Credential;
use Codigito\Auth\Credential\Domain\Repository\CredentialWriter;
use Codigito\Auth\Credential\Domain\ValueObject\CredentialId;
use Codigito\Auth\Credential\Infraestructure\Doctrine\Model\CredentialDoctrine;
use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Exception\InvalidParameterException;
use Codigito\Shared\Domain\Exception\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CredentialWriterDoctrine extends ServiceEntityRepository implements CredentialWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

    public function __construct(
        private EntityManagerInterface $manager,
        private ManagerRegistry $registry,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct($registry, CredentialDoctrine::class);

        $this->resetManager();
    }

    public function delete(CredentialId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof NotFoundException) {
                throw $th;
            }
            throw new InternalErrorException('cant delete credential: '.$id->value);
        }
    }

    private function getFromId(CredentialId $id): CredentialDoctrine
    {
        $result = null;

        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(CredentialDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();
        try {
            $result = $query->getSingleResult();
        } catch (\Throwable) {
            throw new NotFoundException('user not found id: '.$id->value);
        }

        return $result;
    }

    public function update(Credential $credential): void
    {
        $doctrine = $this->manager->find(CredentialDoctrine::class, $credential->id->value);
        if (is_null($doctrine)) {
            throw new NotFoundException('credential not found: '.$credential->id->value);
        }

        $doctrine->setPassword($credential->password);

        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->update(CredentialDoctrine::class, 'c');
            $queryBuilder->set('c.password', ':password');
            $queryBuilder->where('c.id = :id');
            $queryBuilder->setParameter('id', $credential->id->value);
            $queryBuilder->setParameter('password', $credential->password->value);
            $queryBuilder->getQuery()->execute();
        } catch (\Throwable) {
            throw new InternalErrorException('cant update credential: '.$credential->id->value);
        }
    }

    public function create(Credential $credential): void
    {
        try {
            $doctrineModel  = new CredentialDoctrine($credential);
            $hashedPassword = $this->hasher->hashPassword(
                $doctrineModel,
                $credential->password->value
            );
            $doctrineModel->setPassword($hashedPassword);

            $this->manager->persist($doctrineModel);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidParameterException('credential duplicate email: '.$credential->email->value);
            }
            throw new InternalErrorException('cant save credential: '.$credential->id->value);
        }
    }

    private function resetManager(): void
    {
        if ($this->manager->isOpen()) {
            return;
        }

        $this->manager = $this->manager->create(
            $this->manager->getConnection(),
            $this->manager->getConfiguration()
        );
    }
}
