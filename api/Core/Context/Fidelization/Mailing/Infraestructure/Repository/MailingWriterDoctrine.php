<?php

declare(strict_types=1);

namespace Core\Context\Fidelization\Mailing\Infraestructure\Repository;

use Throwable;
use Doctrine\ORM\EntityManagerInterface;
use Core\Context\Fidelization\Mailing\Domain\Model\Mailing;
use Core\Context\Fidelization\Mailing\Domain\ValueObject\MailingId;
use Core\Context\Fidelization\Mailing\Domain\Repository\MailingWriter;
use Core\Context\Fidelization\Mailing\Domain\Exception\MailingCantSaveException;
use Core\Context\Fidelization\Mailing\Domain\Exception\MailingNotFoundException;
use Core\Context\Fidelization\Mailing\Domain\Exception\MailingCantDeleteException;
use Core\Context\Fidelization\Mailing\Domain\Exception\MailingCantUpdateException;
use Core\Context\Fidelization\Mailing\Infraestructure\Doctrine\Model\MailingDoctrine;
use Core\Context\Fidelization\Mailing\Domain\Exception\InvalidMailingDuplicateEmailException;

class MailingWriterDoctrine implements MailingWriter
{
    public const DUPLICATE_ERROR_CODE = 1062;

    public function __construct(
        private EntityManagerInterface $manager
    ) {
        $this->resetManager();
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

    public function update(Mailing $mailing): void
    {
        $doctrine = $this->manager->find(MailingDoctrine::class, $mailing->id->value);
        if (is_null($doctrine)) {
            throw new MailingNotFoundException($mailing->id->value);
        }

        if ($mailing->isConfirmed() && $doctrine->isConfirmed()) {
            return;
        }

        try {
            $queryBuilder = $this->manager->createQueryBuilder();
            $queryBuilder->update(MailingDoctrine::class, 'c');
            $queryBuilder->set('c.confirmed', 1);
            $queryBuilder->where('c.id = :id');
            $queryBuilder->setParameter('id', $mailing->id->value);
            $queryBuilder->getQuery()->execute();
        } catch (Throwable) {
            throw new MailingCantUpdateException($mailing->id->value);
        }
    }

    public function create(Mailing $mailing): void
    {
        try {
            $this->manager->persist(new MailingDoctrine($mailing));
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidMailingDuplicateEmailException($mailing->email->value);
            }
            throw new MailingCantSaveException($mailing->id->value);
        }
    }

    public function delete(MailingId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof MailingNotFoundException) {
                throw $th;
            }
            throw new MailingCantDeleteException($id->value);
        }
    }

    private function getFromId(MailingId $id): MailingDoctrine
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(MailingDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();

        try {
            $result = $query->getSingleResult();
        } catch (Throwable) {
            throw new MailingNotFoundException($id->value);
        }

        return $result;
    }
}
