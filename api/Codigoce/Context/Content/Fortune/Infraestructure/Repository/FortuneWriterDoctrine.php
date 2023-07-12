<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Fortune\Infraestructure\Repository;

use Codigoce\Context\Content\Fortune\Domain\Exception\FortuneCantDeleteException;
use Codigoce\Context\Content\Fortune\Domain\Exception\FortuneCantSaveException;
use Codigoce\Context\Content\Fortune\Domain\Exception\FortuneNotFoundException;
use Codigoce\Context\Content\Fortune\Domain\Exception\InvalidFortuneDuplicateEmailException;
use Codigoce\Context\Content\Fortune\Domain\Model\Fortune;
use Codigoce\Context\Content\Fortune\Domain\Repository\FortuneWriter;
use Codigoce\Context\Content\Fortune\Domain\ValueObject\FortuneId;
use Codigoce\Context\Content\Fortune\Infraestructure\Doctrine\Model\FortuneDoctrine;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class FortuneWriterDoctrine implements FortuneWriter
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

    public function create(Fortune $fortune): void
    {
        try {
            $this->manager->persist(new FortuneDoctrine($fortune));
            $this->manager->flush();
        } catch (\Throwable $th) {
            if (self::DUPLICATE_ERROR_CODE === $th->getCode()) {
                throw new InvalidFortuneDuplicateEmailException($fortune->name->value);
            }
            throw new FortuneCantSaveException($fortune->id->value);
        }
    }

    public function delete(FortuneId $id): void
    {
        try {
            $model = $this->getFromId($id);
            $this->manager->remove($model);
            $this->manager->flush();
        } catch (\Throwable $th) {
            if ($th instanceof FortuneNotFoundException) {
                throw $th;
            }
            throw new FortuneCantDeleteException($id->value);
        }
    }

    private function getFromId(FortuneId $id): FortuneDoctrine
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select('u')
            ->from(FortuneDoctrine::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id->value)
            ->setMaxResults(1);
        $query = $qb->getQuery();

        try {
            $result = $query->getSingleResult();
        } catch (Throwable) {
            throw new FortuneNotFoundException($id->value);
        }

        return $result;
    }
}
